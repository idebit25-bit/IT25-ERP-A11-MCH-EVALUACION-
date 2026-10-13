<?php

namespace Tests\Feature;

use App\Models\{Document, User};
use App\Services\DocumentFileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{DB, Storage};
use Mockery;
use Tests\TestCase;

class DocumentManagementTest extends TestCase
{
    private User $super;
    private User $admin;
    private User $employee;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Storage::fake('documents');
        Storage::fake('public');
        DB::unprepared(<<<'SQL'
CREATE TABLE users (id INTEGER PRIMARY KEY, first_name TEXT, email TEXT, password TEXT, status TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE roles (id INTEGER PRIMARY KEY, name TEXT, guard_name TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE permissions (id INTEGER PRIMARY KEY, name TEXT, guard_name TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE role_has_permissions (role_id INTEGER, permission_id INTEGER);
CREATE TABLE model_has_roles (role_id INTEGER, model_id INTEGER, model_type TEXT);
CREATE TABLE documents (id INTEGER PRIMARY KEY, code TEXT UNIQUE, name TEXT, type TEXT, version TEXT, status TEXT, expiration_date TEXT, file_path TEXT, created_by INTEGER, created_at TEXT, updated_at TEXT);
SQL);
        (require database_path('migrations/2026_10_08_000001_configure_access_control.php'))->up();
        (require database_path('migrations/2026_10_08_000002_create_notifications_table.php'))->up();
        (require database_path('migrations/2026_10_10_000001_create_document_counters_table.php'))->up();
        foreach (['super' => 'Super Admin', 'admin' => 'Admin', 'employee' => 'Usuario'] as $property => $role) {
            $user = User::create(['first_name' => $property, 'email' => $property.'@test.com', 'password' => '12345678', 'status' => 'active']);
            $user->accessRoles()->attach(DB::table('roles')->where('name', $role)->value('id'), ['model_type' => User::class]);
            $this->$property = $user;
        }
    }

    private function data(): array
    {
        return ['name' => 'Manual de prueba', 'type' => 'Manual', 'version' => '1.0', 'status' => 'Vigente', 'expiration_date' => null];
    }

    private function pdf(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('manual.pdf', "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n%%EOF");
    }

    private function createDocument(): Document
    {
        $this->actingAs($this->super)->post('/documentos', $this->data() + ['document' => $this->pdf()])->assertRedirect('/documentos');
        return Document::latest('id')->firstOrFail();
    }

    public function test_upload_replace_metadata_only_and_private_download(): void
    {
        $document = $this->createDocument();
        $first = $document->file_path;
        Storage::disk('documents')->assertExists($first);
        Storage::disk('public')->assertMissing($first);
        $this->get('/documentos/create')->assertOk()->assertSee('multipart/form-data')->assertSee('name="document"', false);
        $this->get('/documentos/'.$document->id.'/edit')->assertOk()->assertSee('Ver PDF');
        $this->get('/documentos/'.$document->id)->assertOk()->assertSee('Sin vencimiento');
        $this->actingAs($this->admin)->put('/documentos/'.$document->id, $this->data())->assertRedirect();
        $this->assertSame($first, $document->fresh()->file_path);
        $this->put('/documentos/'.$document->id, $this->data() + ['document' => $this->pdf()])->assertRedirect();
        $second = $document->fresh()->file_path;
        $this->assertNotSame($first, $second);
        Storage::disk('documents')->assertExists($second);
        Storage::disk('documents')->assertMissing($first);
        $this->actingAs($this->employee)->get('/documentos/'.$document->id.'/archivo')->assertOk()->assertHeader('Content-Type', 'application/pdf');
        $response = $this->get('/documentos/'.$document->id.'/archivo?download=1')->assertOk();
        $this->assertStringStartsWith('attachment;', $response->headers->get('Content-Disposition'));
        $this->put('/documentos/'.$document->id, $this->data())->assertForbidden();
        $this->delete('/documentos/'.$document->id)->assertForbidden();
        $this->actingAs($this->super)->delete('/documentos/'.$document->id)->assertRedirect();
        Storage::disk('documents')->assertMissing($second);
    }

    public function test_invalid_upload_and_write_failure_preserve_the_old_pdf(): void
    {
        $document = $this->createDocument();
        $first = $document->file_path;
        $this->putJson('/documentos/'.$document->id, array_replace($this->data(), ['type' => 'Invalid']))->assertUnprocessable();
        $this->putJson('/documentos/'.$document->id, array_replace($this->data(), ['status' => 'Invalid']))->assertUnprocessable();
        $this->put('/documentos/'.$document->id, $this->data() + ['document' => UploadedFile::fake()->createWithContent('fake.pdf', 'not a PDF')])->assertSessionHasErrors('document');
        $this->post('/documentos', $this->data() + ['document' => UploadedFile::fake()->create('big.pdf', 5121, 'application/pdf')])->assertSessionHasErrors('document');
        Storage::shouldReceive('disk')->with('documents')->andReturn($disk = Mockery::mock());
        $disk->shouldReceive('putFileAs')->andThrow(new \RuntimeException('Storage unavailable'));
        $this->put('/documentos/'.$document->id, $this->data() + ['document' => $this->pdf()])->assertSessionHasErrors('document');
        $this->assertSame($first, $document->fresh()->file_path);
    }

    public function test_missing_files_and_permissions(): void
    {
        $document = $this->createDocument();
        Storage::disk('documents')->delete($document->file_path);
        $this->actingAs($this->employee)->get('/documentos/'.$document->id)->assertOk()->assertSee('El archivo PDF no está disponible.')->assertDontSee('>Ver PDF<', false);
        $this->get('/documentos/'.$document->id.'/archivo')->assertRedirect('/documentos/'.$document->id)->assertSessionHas('error');
        $this->employee->update(['status' => 'inactive']);
        $this->actingAs($this->employee->fresh())->get('/documentos/'.$document->id.'/archivo')->assertForbidden();
        DB::table('role_has_permissions')->delete();
        $this->actingAs($this->admin->fresh())->post('/documentos', $this->data() + ['document' => $this->pdf()])->assertForbidden();
        auth()->logout();
        $this->get('/documentos/'.$document->id.'/archivo')->assertRedirect('/login');
    }

    public function test_counter_does_not_reuse_deleted_codes_and_legacy_files_are_moved(): void
    {
        $first = $this->createDocument();
        $first->delete();
        $second = $this->createDocument();
        $this->assertNotSame($first->code, $second->code);
        $contents = Storage::disk('documents')->get($second->file_path);
        Storage::disk('documents')->delete($second->file_path);
        Storage::disk('public')->put($second->file_path, $contents);
        $this->artisan('documentos:privatizar')->assertSuccessful();
        Storage::disk('public')->assertMissing($second->file_path);
        $this->assertSame($contents, Storage::disk('documents')->get($second->file_path));
        $this->artisan('documentos:privatizar')->assertSuccessful();
    }
}
