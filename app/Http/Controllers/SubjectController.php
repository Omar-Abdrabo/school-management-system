<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Repositories\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function __construct(protected SubjectRepositoryInterface $subjectRepo) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->subjectRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->subjectRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        return $this->subjectRepo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->subjectRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request)
    {
        return $this->subjectRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->subjectRepo->destroy($request);
    }
}
