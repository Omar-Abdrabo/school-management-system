<?php

namespace App\Http\Traits;

use Jubaer\Zoom\Facades\Zoom;

trait MeetingZoomTrait
{

    public function createMeeting($request)
    {

        $meeting = Zoom::createMeeting([
            // "agenda" => 'your agenda',
            "topic" => $request->topic,
            "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
            "duration" => 40, // in minutes
            "timezone" => config('zoom.timezone'), // set your timezone
            "password" => 'password',
            "start_time" => $request->start_time, // set your start time
            // "template_id" => 'set your template id', // set your template id  Ex: "Dv4YdINdTk+Z5RToadh5ug==" from https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingtemplates
            "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
            // "schedule_for" => 'set your schedule for profile email ', // set your schedule for
            "settings" => [
                'join_before_host' => false, // if you want to join before host set true otherwise set false
                'host_video' => false, // if you want to start video when host join set true otherwise set false
                'participant_video' => false, // if you want to start video when participants join set true otherwise set false
                'mute_upon_entry' => true, // if you want to mute participants when they join the meeting set true otherwise set false
                'waiting_room' => true, // if you want to use waiting room for participants set true otherwise set false
                'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
                'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
                'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
            ],
        ]);
        return $meeting;

        // $user = Zoom::user()->first();
        // $meetingData = [
        //     'topic' => $request->topic,
        //     'duration' => $request->duration,
        //     'password' => $request->password,
        //     'start_time' => $request->start_time,
        //     'timezone' => config('zoom.timezone'),
        //     // 'timezone' => 'Africa/Cairo'
        // ];
        // $meeting = Zoom::meeting()->make($meetingData);
        // $meeting->settings()->make([
        //     'join_before_host' => false,
        //     'host_video' => false,
        //     'participant_video' => false,
        //     'mute_upon_entry' => true,
        //     'waiting_room' => true,
        //     'approval_type' => config('zoom.approval_type'),
        //     'audio' => config('zoom.audio'),
        //     'auto_recording' => config('zoom.auto_recording')
        // ]);
        // return $user->meetings()->save($meeting);
    }
}
