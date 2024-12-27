<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Support\Arr;
use App\Models\OnlineClasse;
use Jubaer\Zoom\Facades\Zoom;
use Jubaer\Zoom\Zoom as ZoomZoom;
use App\Http\Traits\MeetingZoomTrait;
use App\Http\Requests\StoreOnlineClasseRequest;
use App\Http\Requests\UpdateOnlineClasseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineClasseController extends Controller
{

    use MeetingZoomTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $online_classes =  OnlineClasse::where('created_by', Auth::user()->email)->get();
        return view('pages.online_classes.index', compact('online_classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        return view('pages.online_classes.add', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOnlineClasseRequest $request)
    {
        try {
            $meeting = $this->createMeeting($request);
            // dd($meeting['data']);
            OnlineClasse::create([
                'integration' => true,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->email,
                'meeting_id' => $meeting['data']['id'],
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $meeting['data']['duration'],
                'password' => $meeting['data']['password'],
                'start_url' => $meeting['data']['start_url'],
                'join_url' => $meeting['data']['join_url'],
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('online_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function indirectCreate()
    {
        $grades = Grade::all();
        return view('pages.online_classes.indirect', compact('grades'));
    }

    public function indirectStore(Request $request)
    {
        $request->validate([
            'grade_id' => 'required',
            'classroom_id' => 'required',
            'section_id' => 'required',
            'meeting_id' => 'required',
            'topic' => 'required',
            'start_time' => 'required',
            'duration' => 'required',
            'password' => 'required',
            'start_url' => 'required',
            'join_url' => 'required',
        ]);
        // dd($request->all());
        try {
            OnlineClasse::create([
                'integration' => false,
                'grade_id' => $request->grade_id,
                'classroom_id' => $request->classroom_id,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->email,
                'meeting_id' => $request->meeting_id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'start_url' => $request->start_url,
                'join_url' => $request->join_url,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('online_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $meeting = Zoom::deleteMeeting($request->meeting_id); // REMOVE IT if you dont integrate with ZOOM
            // dd($meeting['status']);
            OnlineClasse::where('meeting_id', $request->meeting_id)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('online_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
