<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Library;
use App\Http\Traits\AttachFilesTrait;

class LibraryRepository implements LibraryRepositoryInterface
{
    use AttachFilesTrait;

    public function index()
    {
        $books = Library::all();
        return view('pages.library.index', compact('books'));
    }

    public function create()
    {
        $grades = Grade::all();
        return view('pages.library.create', compact('grades'));
    }

    public function store($request)
    {
        try {
            Library::create([
                'title' => $request->title,
                'file_name' => $request->file('file_name')->getClientOriginalName(),
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'teacher_id' => 1,
            ]);
            $this->uploadFile($request, 'file_name', 'library');
            toastr()->success(trans('messages.success'));
            return redirect()->route('library.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $book  = Library::findOrFail($id);
        $grades = Grade::all();
        return view('pages.library.edit', compact('book', 'grades'));
    }

    public function update($request)
    {
        try {
            $book = Library::findOrFail($request->id);
            $book->title = $request->title;
            $book->grade_id = $request->grade_id;
            $book->classroom_id = $request->classroom_id;
            $book->section_id = $request->section_id;
            $book->teacher_id = 1;
            if ($request->hasFile('file_name')) {
                $this->deleteFile($book->file_name, 'library');
                $this->uploadFile($request, 'file_name', 'library');
                $file_name_new = $request->file('file_name')->getClientOriginalName();
                $book->file_name = $book->file_name !== $file_name_new ? $file_name_new : $book->file_name;
            }
            $book->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            $this->deleteFile($request->file_name, 'library');
            Library::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function download($filename)
    {
        $file_path = public_path('storage\\attachments\\library\\' . $filename);
        return response()->download($file_path);
    }
}
