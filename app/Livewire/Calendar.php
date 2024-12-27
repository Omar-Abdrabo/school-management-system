<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class Calendar extends Component
{
    public $events = '';

    public function getevent()
    {
        $events = Event::select('id', 'title', 'start')->get();

        return  json_encode($events);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addevent($event)
    {
        $input['title'] = $event['title'];
        $input['start'] = $event['start'];
        Event::create($input);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function eventDrop($event, $oldEvent)
    {
        $eventdata = Event::find($event['id']);
        $eventdata->start = $event['start'];
        $eventdata->save();
    }

    // public function refresh()
    // {
    //     $this->loadEvents(); // Reload events
    // }

    // private function loadEvents()
    // {
    //     // Logic to fetch events from your data source
    //     $this->events = Event::all(); // Example
    // }

    public function deleteEvent($eventId)
    {
        // Logic to delete the event from your data source
        Event::find($eventId)->delete(); // Example
        // $this->emit('refreshCalendar'); // Refresh calendar after deletion
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $events = Event::select('id', 'title', 'start')->get();
        $this->events = json_encode($events);
        return view('livewire.calendar');
    }
}
