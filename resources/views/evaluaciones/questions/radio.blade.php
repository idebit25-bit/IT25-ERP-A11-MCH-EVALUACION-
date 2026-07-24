<div class="mt-3">

    <label class="form-label">
        <strong>Respuesta</strong>
    </label>

    @foreach ($question->scale->values as $value)

        <div class="form-check">

            <input
                class="form-check-input"
                type="radio"
                name="answers[{{ $question->id }}]"
                id="question_{{ $question->id }}_value_{{ $value->id }}"
                value="{{ $value->id }}">

            <label
                class="form-check-label"
                for="question_{{ $question->id }}_value_{{ $value->id }}">

                {{ $value->label }}

            </label>

        </div>

    @endforeach

</div>