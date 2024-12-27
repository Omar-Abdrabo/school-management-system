<?php

namespace App\Http\Controllers;

use App\Models\Quizze;
use App\Http\Requests\StoreQuizzeRequest;
use App\Http\Requests\UpdateQuizzeRequest;
use App\Repositories\QuizzeRepositoryInterface;
use Illuminate\Http\Request;

class QuizzeController extends Controller
{
    public function __construct(protected QuizzeRepositoryInterface $quizzeRepo) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->quizzeRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->quizzeRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizzeRequest $request)
    {
        return $this->quizzeRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return $this->quizzeRepo->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->quizzeRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizzeRequest $request)
    {
        return $this->quizzeRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->quizzeRepo->destroy($request);
    }
}
