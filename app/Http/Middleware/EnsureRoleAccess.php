<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        abort_unless($user, 403);
        if ($request->routeIs('logout')) return $next($request);
        abort_unless($user->status === 'active', 403);

        if ($request->routeIs('logout') || $user->hasAccessRole('Super Admin')) {
            return $next($request);
        }

        if ($user->hasAccessRole('Admin')) {
            abort_if($request->is('configuracion/usuarios', 'configuracion/usuarios/*', 'configuracion/roles', 'configuracion/roles/*'), 403);
            if ($request->is('colaboradores/*') && $request->route()->getActionMethod() !== 'show') {
                $target = User::find($request->route('id'));
                abort_if($target && $target->canManageOperations(), 403, 'Sólo el superadministrador administra estas cuentas.');
            }
            $permission = match (true) {
                $request->is('evaluaciones', 'evaluaciones/*') => 'evaluaciones.gestionar',
                $request->is('configuracion', 'configuracion/*') => 'configuracion.evaluaciones',
                $request->is('colaboradores', 'colaboradores/*') => 'colaboradores.gestionar',
                $request->is('reportes', 'reportes/*') => 'reportes.consultar',
                $request->is('documentos', 'documentos/*') && (! in_array($request->method(), ['GET', 'HEAD']) || in_array($request->route()->getActionMethod(), ['create', 'edit'])) => 'documentos.gestionar',
                default => null,
            };
            abort_if($permission && ! $user->hasModulePermission($permission), 403);
            return $next($request);
        }

        abort_unless($user->hasAccessRole('Usuario'), 403);

        if ($request->routeIs('notificaciones.*', 'mis-evaluaciones.*', 'planes.*')) return $next($request);

        if ($request->isMethod('GET') && $request->is('/', 'dashboard')) {
            return redirect('/documentos');
        }

        $action = $request->route()->getActionMethod();
        abort_unless(
            in_array($request->method(), ['GET', 'HEAD'], true)
            && $request->route()->getControllerClass() === \App\Http\Controllers\DocumentoController::class
            && in_array($action, ['index', 'show', 'file', 'manuales', 'formatos', 'politicas', 'procedimientos'], true),
            403,
        );

        return $next($request);
    }
}
