<div>
    <div>
        <div id='calendar-container' wire:ignore>
            <div id='calendar'>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js'></script>
        <script>
            // the previous code was 'livewire:load' this dosenot work with livewire 3 so we use this one 'livewire:initialized'
            document.addEventListener('livewire:initialized', function() {
                var Calendar = FullCalendar.Calendar;
                var Draggable = FullCalendar.Draggable;
                var calendarEl = document.getElementById('calendar');
                var checkbox = document.getElementById('drop-remove');
                var data = @this.events;
                var calendar = new Calendar(calendarEl, {
                    events: JSON.parse(data),
                    dateClick(info) {
                        var title = prompt('ادخل عنوان الحدث ');
                        var date = new Date(info.dateStr + 'T00:00:00');
                        if (title != null && title != '') {
                            calendar.addEvent({
                                title: title,
                                start: date,
                                allDay: true
                            });
                            var eventAdd = {
                                title: title,
                                start: date
                            };
                            @this.addevent(eventAdd).then(() => {
                                // @this.call('refresh');
                                alert('تم اضافة الحدث بنجاح');
                            }).catch(error => {
                                console.error('Error adding event:', error);
                                alert('حدث خطأ أثناء إضافة الحدث');
                            });
                        } else {
                            alert('من فضلك ادخل عنوان الحدث');
                        }
                    },
                    eventContent: function(arg) {
                        let eventTitle = document.createElement('div');
                        eventTitle.style.fontSize = '14px';
                        eventTitle.style.fontWeight = 'bold';
                        eventTitle.style.margin = '3px';  
                        eventTitle.style.marginLeft = '10px';
                        eventTitle.innerText = arg.event.title;

                        // Create the delete button (X icon)
                        let deleteButton = document.createElement('span');
                        deleteButton.innerHTML = ' &#10006;'; // X icon
                        deleteButton.style.cursor = 'pointer';
                        deleteButton.style.marginLeft = '2px';
                        deleteButton.style.color = 'red';

                        // Add click event for the delete button
                        deleteButton.addEventListener('click', function(e) {
                            e.stopPropagation(); // Prevent triggering the eventClick
                            if (confirm('هل أنت متأكد أنك تريد حذف هذا الحدث؟')) {
                                // Remove event from the calendar
                                arg.event.remove();
                                // Call the Livewire method to delete the event
                                @this.deleteEvent(arg.event.id);
                                alert('تم حذف الحدث بنجاح');
                            }
                        });

                        // Append the delete button to the event title
                        eventTitle.appendChild(deleteButton);

                        return {
                            domNodes: [eventTitle]
                        }; // Return the custom element
                    },
                    editable: true,
                    selectable: true,
                    displayEventTime: false,
                    droppable: true, // this allows things to be dropped onto the calendar
                    drop: function(info) {
                        // is the "remove after drop" checkbox checked?
                        if (checkbox.checked) {
                            // if so, remove the element from the "Draggable Events" list
                            info.draggedEl.parentNode.removeChild(info.draggedEl);
                        }
                    },
                    eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
                    loading: function(isLoading) {
                        // calendar.refetchEvents()
                        if (!isLoading) {
                            // Reset custom events
                            this.getEvents().forEach(function(e) {
                                if (e.source === null) {
                                    e.remove();
                                }
                            });
                        }
                    }
                });
                calendar.render();
                @this.on(`refreshCalendar`, () => {
                    calendar.refetchEvents()
                });
            });
        </script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.css' rel='stylesheet' />
    @endpush
</div>
