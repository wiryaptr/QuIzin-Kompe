@php
    $options = old('options', isset($question)
        ? $question->options->map(fn ($o) => ['text' => $o->option_text])->all()
        : array_fill(0, 4, ['text' => '']));
    $correct = old('correct', isset($question)
        ? ($question->options->search(fn ($o) => $o->is_correct) ?: 0)
        : 0);
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Teks Soal</label>
    <textarea name="question_text" rows="3" class="form-control" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Batas Waktu (detik)</label>
    <input type="number" name="time_limit" min="5" max="300" class="form-control" required
    value="{{ old('time_limit', $question->time_limit ?? 30) }}">
</div>

<label class="form-label">Opsi Jawaban (pilih satu yang benar)</label>
@foreach ($options as $i => $opt)
    <div class="input-group mb-2">
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="correct"
                value="{{ $i }}" {{ (int) $correct === $i ? 'checked' : '' }} required>
        </div>
        <input type="text" name="options[{{ $i }}][text]" class="form-control"
            placeholder="Opsi {{ chr(65 + $i) }}" value="{{ $opt['text'] }}" required>
    </div>
@endforeach