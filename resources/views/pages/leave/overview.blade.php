@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        /* .fc-day-sun {
                        color: #FFF;
                        background: red;
                    } */
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
    <div class="card">
        <div class="card-body py-4">
            <div id='calendar'></div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                views: {
                    dayGridMonth: {
                        contentHeight: 950,
                        dayMaxEvents: 5,
                        dayHeaderFormat: {
                            weekday: 'long'
                        }
                    },

                },
                selectable: true,
                editable: true,
                events: [{
                    daysOfWeek: [0, 6], //Sundays and saturdays
                    rendering: "background",
                    color: "#ff9f89",
                    overLap: false,
                    allDay: true,
                    display: 'background'
                }],
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    console.log( start.start , 'start');
                    console.log( end , 'end');
                    var title = prompt('Event Title:');
                    if (title) {
                        var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                        var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD');
                        $.ajax({
                            url: 'createevent',
                            data: 'title=' + title + '&start=' + start + '&end=' + end +
                                '&_token=' + "{{ csrf_token() }}",
                            type: "post",
                            success: function(data) {
                                alert("Added Successfully");
                            }
                        });
                        calendar.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true
                        );
                    }
                    calendar.fullCalendar('unselect');
                },

            });
            calendar.on('dateClick', function(info) {
                console.log('clicked on ' + info.dateStr);
            });
            calendar.render();

        });


        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>
@endsection
