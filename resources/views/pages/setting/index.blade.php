@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
<style type="text/css">
    .form-label{
        font-weight:510 !important;
    }
</style>
@section('content')

<div class="card">
<div class="contrainer-fluid mt-4">
<div class="mt-4" style="text-align:center; ">
        <h2>Year End Process</h2>
       
    </div>
    @php
    $fromYear = $acadamic->from_year.'-'.$acadamic->from_month.'-01';
    $toYear = $acadamic->to_year.'-'.$acadamic->to_month.'-01';
    $acadamic_fromDate = date('Y-m-d', strtotime($fromYear));
    $acadamic_toDate = date('Y-m-t', strtotime($toYear) );

    $CalenderfromYear = $calender->year.'-'.$calender->from_month.'-01';
    $CalendertoYear = $calender->year.'-'.$calender->to_month.'-01';
    $calender_fromDate = date('Y-m-d', strtotime($CalenderfromYear));
    $calender_toDate = date('Y-m-t', strtotime($CalendertoYear) );
    @endphp
    <div class="card-body py-4">
        <form id="set_acadamic">
        <div class="row mt-4">
        
        <div class="col-sm-3"> <label for="" class="form-label mt-4">Acadamic Year</label></div>
        <div class="col-sm-3">
            <input type="date" class="form-control " name="from_date" value="{{$acadamic_fromDate}}" required>
        </div>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="to_date" value="{{$acadamic_toDate}}" required>
        </div>
        <input type="hidden" name="type" value="academic">
        <div class="col-sm-3"> <button class="btn btn-primary btn-sm mt-2" type="button" id="set_acadamic" onclick="SetAcadamicYear()"> Update </button></div>
        
        </div>
        </form>
    <form id="set_calender">
         <div class="row mt-4">
        <div class="col-sm-3"> <label for="" class="form-label mt-4">Calender Year</label></div>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="from_date" value="{{$calender_fromDate}}" required >
        </div>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="to_date" value="{{$calender_toDate}}" required>
        </div>
        <input type="hidden" name="type" value="calender">
        <div class="col-sm-3"> <button class="btn btn-primary btn-sm mt-2" type="button" id="set_calender" onclick="SetCalenderYear()"> Update </button></div>
        </div>
    </form>
     <form id="set_calender">
         <div class="row mt-4">
        <input type="hidden" name="type" value="yep">
        <div class="col-sm-3"> <label for="" class="form-label mt-4">Year End Process</label></div>
        <div class="col-sm-6"> <button class="btn btn-primary btn-sm mt-2" type="button" id="regime_button" onclick="ReSetEndProcess()"> Reset All Yearwise Data </button></div>
        </div>
    </form>
    </div>
</div>
</div>


@endsection

@section('add_on_script')

<script>
    let today = new Date().toISOString().split("T")[0];
    for (let i = 0; i < 2; i++) {
      document.getElementsByName("from_date")[i].setAttribute("min", today);
      document.getElementsByName("to_date")[i].setAttribute("min", today);
      console.log(i);
     }
    function SetAcadamicYear() {
       var formData =$("#set_acadamic").serialize();
        Swal.fire({
            text: "All the existing Acadamic data. Do you want to Proceed?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('yep.update') }}",
                    type: 'POST',
                    data:formData,
                    success: function(res) {
                        if( res.error == 0 ) {

                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });
                            window.location.reload(); 
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: res.message,
                                icon: "danger",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                timer: 3000
                            });
                        }

                    },
                    error: function(xhr, err) {
                        if (xhr.status == 403) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });
            }
        });
    }
    function SetCalenderYear() {
       var formData =$("#set_calender").serialize();
        Swal.fire({
            text: "All the existing Calender data. Do you want to Proceed?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('yep.update') }}",
                    type: 'POST',
                    data:formData,
                    success: function(res) {
                        if( res.error == 0 ) {

                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });
                          window.location.reload(); 
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: res.message,
                                icon: "danger",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                timer: 3000
                            });
                        }

                    },
                    error: function(xhr, err) {
                        if (xhr.status == 403) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });
            }
        });
    }
    function ReSetEndProcess() {
       var formData =[];
        Swal.fire({
            text: "This will reset all the year wise data to the newly created year, Do you want to proceed?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('yep.update') }}",
                    type: 'POST',
                    data:formData,
                    success: function(res) {
                        if( res.error == 0 ) {

                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });
                           window.location.reload();  
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: res.message,
                                icon: "danger",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                },
                                timer: 3000
                            });
                           
                        }

                    },
                    error: function(xhr, err) {
                        if (xhr.status == 403) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });
            }
        });
    }
</script>

@endsection
