<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Gate;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = auth()->user()->quizzes()->withCount('questions')->latest()->paginate(10);

        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $quiz = auth()->user()->quizzes()->create($data);

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Kuis berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        Gate::authorize('view', $quiz);
        $quiz->load('questions.options');

        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        Gate::authorize('update', $quiz);

        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        Gate::authorize('update', $quiz);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $quiz->update($data);

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Kuis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        Gate::authorize('delete', $quiz);

        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Kuis berhasil dihapus.');
    }

    public function stats(Quiz $quiz)
    {
        Gate::authorize('view', $quiz);

        $questions = $quiz->questions()
            ->withCount([
                'answers as total_answers',
                'answers as wrong_answers' => fn ($q) => $q->where('is_correct', false),
            ])
            ->get()
            ->map(function ($question) {
                $question->wrong_percent = $question->total_answers > 0
                    ? round($question->wrong_answers / $question->total_answers * 100)
                    : 0;

                return $question;
            })
            ->sortByDesc('wrong_percent')
            ->values();

        return view('quizzes.stats', compact('quiz', 'questions'));
    }
}
