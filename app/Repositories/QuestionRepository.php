<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\Quizze;

class QuestionRepository implements QuestionRepositoryInterface
{

    public function index()
    {
        $questions = Question::all();
        return view('pages.Questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quizze::all();
        return view('pages.Questions.create', compact('quizzes'));
    }

    public function store($request)
    {
        // dd($request);
        try {
            Question::create([
                'title' => $request->title,
                'answers' => $request->answers,
                'correct_answers' => $request->correct_answers,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('questions.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function edit($id) 
    {
        $question = Question::findOrFail($id);
        $quizzes = Quizze::all();
        return view('pages.Questions.edit', compact('question', 'quizzes'));
    }

    public function update($request) 
    {
        // dd($request);
        try {
            $question = Question::findOrFail($request->id);
            $question->update([
                'title' => $request->title,
                'answers' => $request->answers,
                'correct_answers' => $request->correct_answers,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('questions.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($request) 
    {
        try {
            Question::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('questions.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }
}
