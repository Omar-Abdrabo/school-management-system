<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function __construct(protected QuestionRepositoryInterface $questionRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->questionRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->questionRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        return $this->questionRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->questionRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request)
    {
        return $this->questionRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->questionRepo->destroy($request);
    }
}
