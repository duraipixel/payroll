@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .fc-event {
            display: flex !important;
            justify-content: end;
            align-items: flex-end;
            color: white;
        }

        td.fc-bgevent {
            display: flex;
            height: 100%;
            color: white;
            align-items: end;
            justify-content: end;
        }

        .fc-bgevent {
            opacity: .5 !important;
        }

        button.fc-button {
            display: flex;
            align-items: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script> --}}
    <div class="card">
        <div class="card-body py-4">
            <div class="row">
                <div class="col-sm-8">
                    <div id='calendar'></div>
                </div>
                <div class="col sm-4">
                    <div class="card" id="days_count">
                        {{-- @include('pages.leave._days_count') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $(document).ready(function() {

            $('#staff_id').select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#calendar').fullCalendar({

                events: "{{ route('calender.event.get') }}",
                eventAfterRender: function(event, element, view) {
                    element.append(event.title);
                },
                selectable: true,
                selectHelper: true,

                select: function(start, end, allDays) {
                    var start_date = moment(start).format('YYYY-MM-DD');
                    var end_date = moment(end).format('YYYY-MM-DD');
                    setDayDetails(start_date, end_date, calendar);
                },
                editable: true,
                eventDrop: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD');
                    var end_date = moment(event.end).format('YYYY-MM-DD');

                },
                eventClick: function(event) {
                    var id = event.id;
                    if (confirm('Are you sure want to remove it')) {

                    }
                },
                viewRender: function(view, element) {
                    var b = $('#calendar').fullCalendar('getDate');
                    // alert( moment(b).format('YYYY-MM-DD'));
                    getDaysCount(moment(b).format('YYYY-MM-DD'));
                },

            });

        });

        async function setDayDetails(from, to, calendar) {

            var {
                value: selected_day
            } = await Swal.fire({
                title: 'Set ' + moment(from).format('MMM DD') + ' to ' + moment(to).subtract(1, "days").format(
                    'MMM DD') + ' as ',
                html: '<select class="form-control" name="day_type" id="day_type"><option value="">--select--</option><option value="working_day">Working Day</option><option value="week_off">Week Off</option><option value="holiday">Holiday</option></select>' +
                    '<input id="swal-input1" class="form-control mt-5" name="comments" value="" placeholder="Comments">',
                showCancelButton: true,
                focusConfirm: true,
                preConfirm: () => {
                    return {
                        day_type: $('#day_type').val(),
                        comments: $('#swal-input1').val()
                    };
                }

            }).then((result) => {

                if (result.value.day_type == '') {
                    Swal.fire('Day type cannot be empty')
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('calender.event.add') }}",
                        type: "POST",
                        data: {
                            day_type: result.value.day_type,
                            comments: result.value.comments == 'undefined' ? '' : result.value.comments,
                            from: from,
                            to: to
                        },
                        success: function(res) {
                            if (res.error == 0) {
                                Swal.fire(res.message);
                                setTimeout(() => {

                                    $('#calendar').fullCalendar('refetchEvents')
                                    // location.reload();
                                    getDaysCount(moment(from).format('YYYY-MM-DD'));
                                }, 300);
                            }
                        }
                    });
                }
            })

        }

        function getDaysCount(current_date) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('calender.get.count') }}",
                type: "POST",
                data: {
                    date: current_date
                },
                success: function(res) {
                    $('#days_count').html(res);
                }
            });

        }

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>
@endsection
