<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Quiz $quiz)
    {
        $this->authorizeQuiz($quiz);
        $questions = $quiz->questions()->with('options')->get();
        return view('questions.index', compact('quiz', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Quiz $quiz)
    {
        $this->authorizeQuiz($quiz);
        return view('questions.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $this->authorizeQuiz($quiz);
        $data = $request->validate($this->rules());
        abort_unless(isset($data['options'][$data['correct']]), 422);

        DB::transaction(function () use ($quiz, $data) {
            $question = $quiz->questions()->create([
                'question_text' => $data['question_text'],
                'time_limit'    => $data['time_limit'] ?? null,
            ]);

            foreach ($data['options'] as $i => $opt) {
                $question->options()->create([
                    'option_text' => $opt['text'],
                    'is_correct'  => $i === (int) $data['correct'],
                ]);
            }
        });

        return redirect()->route('quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $this->authorizeQuiz($question->quiz);
        $question->load('options');
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $this->authorizeQuiz($question->quiz);
        $data = $request->validate($this->rules());
        abort_unless(isset($data['options'][$data['correct']]), 422);

        DB::transaction(function () use ($question, $data) {
            $question->update([
                'question_text' => $data['question_text'],
                'time_limit'    => $data['time_limit'] ?? null,
            ]);

            // Cara paling simpel: hapus opsi lama, buat ulang
            $question->options()->delete();
            foreach ($data['options'] as $i => $opt) {
                $question->options()->create([
                    'option_text' => $opt['text'],
                    'is_correct'  => $i === (int) $data['correct'],
                ]);
            }
        });

        return redirect()->route('quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $this->authorizeQuiz($question->quiz);
        $quizId = $question->quiz_id;
        $question->delete(); // opsi ikut terhapus kalau FK cascadeOnDelete
        return redirect()->route('quizzes.questions.index', $quizId)
            ->with('success', 'Soal dihapus.');
    }

    private function authorizeQuiz(Quiz $quiz): void
    {
        abort_if($quiz->user_id !== auth()->id(), 403);
    }

    private function rules(): array
    {
        return [
            'question_text'      => 'required|string|max:500',
            'time_limit'         => 'required|integer|min:5|max:300',
            'options'            => 'required|array|min:2|max:6',
            'options.*.text'     => 'required|string|max:255',
            'correct'            => 'required|integer|min:0', // index opsi yang benar
        ];
    }

}
