<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use App\Repositories\LibraryRepositoryInterface;
use Illuminate\Http\Request;

class LibraryController extends Controller
{

    public function __construct(protected LibraryRepositoryInterface $libraryRepo) {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->libraryRepo->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->libraryRepo->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLibraryRequest $request)
    {
        return $this->libraryRepo->store($request);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->libraryRepo->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLibraryRequest $request, Library $library)
    {
        return $this->libraryRepo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->libraryRepo->destroy($request);
    }

    public function downloadFile($filename)
    {
        return $this->libraryRepo->download($filename);
    }
}
