@extends('layouts.template')
@section('breadcrum')
@include('layouts.parts.breadcrum')
@endsection
@section('content')
<style>

  .popup {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-align: center;
    position: fixed;
    .popup__content {
      width: 80%;
      overflow:auto;
      padding: 50px;
      background: white;
      color: black;
      position: relative;
      top: 48%;
      left: 59%;
      transform: translate(-50%, -50%);
      box-sizing: border-box;
      .close {
        position: absolute;
        right: 20px;
        top: 20px;
        width: 20px;
        display: block;
        span {
          cursor: pointer;
          position: fixed;
          width: 20px;
          height: 3px;
          background: #099ccc;
          &:nth-child(1) {
            transform: rotate(45deg);
          }
          &:nth-child(2) {
            transform: rotate(135deg);
          }
        }
      }
    }
  }
  #grid{
    display:none;
  }
  .typeahead-pane {
    position: absolute;
    width: 100%;
    background: #ffffff;
    margin: 0;
    padding: 0;
    border-radius: 6px;
    box-shadow: 1px 2px 3px 2px #ddd;
    z-index: 1;
  }

  .typeahead-pane-ul {
    width: 100%;
    padding: 0;
  }

  .typeahead-pane-li {
    padding: 8px 15px;
    width: 100%;
    margin: 0;
    border-bottom: 1px solid #2e3d4638;

  }

  .typeahead-pane-li:hover {
    background: #3a81bf;
    color: white;
    cursor: pointer;
  }

  #input-close {
    position: absolute;
    top: 11px;
    right: 15px;
  }

  .daterangepicker.show-calendar .ranges {
    height: 0;
  }

  #leave_table_staff th,
  #nature_table_staff th {
    padding: 5px;
  }

  #leave_table_staff td,
  #nature_table_staff td {
    padding: 5px;
  }


  @media only screen {
    .toggleSwitch {
      display: inline-block;
      height: 18px;
      position: relative;
      overflow: visible;
      padding: 0;
      margin-left: 50px;
      cursor: pointer;
      width: 40px
    }
    .toggleSwitch * {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }
    .toggleSwitch label,
    .toggleSwitch > span {
      line-height: 20px;
      height: 20px;
      vertical-align: middle;
    }
    .toggleSwitch input:focus ~ a,
    .toggleSwitch input:focus + label {
      outline: none;
    }
    .toggleSwitch label {
      position: relative;
      z-index: 3;
      display: block;
      width: 100%;
    }
    .toggleSwitch input {
      position: absolute;
      opacity: 0;
      z-index: 5;
    }
    .toggleSwitch > span {
      position: absolute;
      left: -50px;
      width: 100%;
      margin: 0;
      padding-right: 50px;
      text-align: left;
      white-space: nowrap;
    }
    .toggleSwitch > span span {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 5;
      display: block;
      width: 50%;
      margin-left: 50px;
      text-align: left;
      font-size: 0.9em;
      width: 100%;
      left: 15%;
      top: -1px;
      opacity: 0;
    }
    .toggleSwitch a {
      position: absolute;
      right: 50%;
      z-index: 4;
      display: block;
      height: 100%;
      padding: 0;
      left: 2px;
      width: 18px;
      background-color: #fff;
      border: 1px solid #CCC;
      border-radius: 100%;
      -webkit-transition: all 0.2s ease-out;
      -moz-transition: all 0.2s ease-out;
      transition: all 0.2s ease-out;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .toggleSwitch > span span:first-of-type {
      color: #ccc;
      opacity: 1;
      left: 45%;
    }
    .toggleSwitch > span:before {
      content: '';
      display: block;
      width: 100%;
      height: 100%;
      position: absolute;
      left: 50px;
      top: -2px;
      background-color: #fafafa;
      border: 1px solid #ccc;
      border-radius: 30px;
      -webkit-transition: all 0.2s ease-out;
      -moz-transition: all 0.2s ease-out;
      transition: all 0.2s ease-out;
    }
    .toggleSwitch input:checked ~ a {
      border-color: #fff;
      left: 100%;
      margin-left: -8px;
    }
    .toggleSwitch input:checked ~ span:before {
      border-color: #0097D1;
      box-shadow: inset 0 0 0 30px #0097D1;
    }
    .toggleSwitch input:checked ~ span span:first-of-type {
      opacity: 0;
    }
    .toggleSwitch input:checked ~ span span:last-of-type {
      opacity: 1;
      color: #fff;
    }
/* Switch Sizes */
.toggleSwitch.large {
  width: 60px;
  height: 27px;
}
.toggleSwitch.large a {
  width: 27px;
}
.toggleSwitch.large > span {
  height: 29px;
  line-height: 28px;
}
.toggleSwitch.large input:checked ~ a {
  left: 41px;
}
.toggleSwitch.large > span span {
  font-size: 1.1em;
}
.toggleSwitch.large > span span:first-of-type {
  left: 50%;
}
.toggleSwitch.xlarge {
  width: 80px;
  height: 36px;
}
.toggleSwitch.xlarge a {
  width: 36px;
}
.toggleSwitch.xlarge > span {
  height: 38px;
  line-height: 37px;
}
.toggleSwitch.xlarge input:checked ~ a {
  left: 52px;
}
.toggleSwitch.xlarge > span span {
  font-size: 1.4em;
}
.toggleSwitch.xlarge > span span:first-of-type {
  left: 50%;
}
}
.tresponse th {
  position: sticky;
  top: 0;
  z-index: 1;
  background-color: #181c32;
}
.popupresponse th {
  position: sticky;
  top: 0;
  z-index: 1;
  background-color: #181c32;
}
.tresponse{
  height: 500px !important; 
 overflow-y: scroll !important;
}
.popupresponse{
  height: 150px !important; 
 overflow-y: scroll !important;
}

/*  End Toggle Switch  */

</style>
<div class="card">
  <br>
  <div class="contrainer-fluid">
    <div class="mt-4" style="text-align:center; ">
      <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>

    </div>

    <div class=" " id="dynamic_content">
      {{-- {{ dump($info->staff_info) }} --}}
      <form action="" class="p-3" id="leave_form" autocomplete="off" enctype="multipart/form-data">
        <div class="fv-row form-group mb-3 row">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mb-3">
                <label class="form-label required mt-3" for="">
                  Leave Category
                </label>
              </div>
              <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
              <div class="col-sm-7">
                <select name="leave_category_id" id="leave_category_id" class="form-control"   @if (isset($info->leave_category_id) && $info->leave_category_id) disabled @endif>
                  <option value="">-select-</option>
                  @isset($leave_category)
                  @foreach ($leave_category as $citem)
                  <option value="{{ $citem->id }}"
                    @if (isset($info->leave_category_id) && $info->leave_category_id == $citem->id) selected @endif>{{ $citem->name }}
                  </option>
                  @endforeach
                  @endisset
                </select>
              </div>
            </div>
            <div class="fv-row form-group mb-3 row">
              <div class="col-sm-5">
                <label class="form-label required mt-3" for="">
                  Dates requested
                </label>
              </div>
              <div class="col-sm-7">
                @if( isset( $info->from_date ) && !empty( $info->from_date ) && $type=='approved')
                <input type="hidden" name="requested_date" id="requested_date"
                value="{{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }}"
                class="form-control">
                <label for="" class="mt-3"> {{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }} </label>
                @elseif(isset( $info->from_date ) && !empty( $info->from_date ) && $type=='edit')
                <input type="text" name="requested_date" id="requested_date"
                value="{{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }}"
                class="form-control">
                @else
                <input type="text" name="requested_date" id="requested_date"
                value="{{ isset($info->from_date) ? date('d/m/Y', strtotime($info->from_date)) . ' - ' . date('d/m/Y', strtotime($info->to_date)) : '' }}"
                class="form-control">

                @endif

              </div>
            </div>
            <div class="fv-row form-group mb-3 row">
            </div>

            <div class="fv-row form-group mb-3 row">
              <div class="col-sm-5">
                <label class="form-label required mt-3" for="">No.of.Days requested </label>
              </div>
              <div class="col-sm-7">
                <input type="text" readonly name="no_of_days" id="no_of_days"
                value="{{  number_format($info->no_of_days?? 0 ,1 ) }}" class="form-control">
              </div> 
            </div>






            <div class="fv-row form-group mb-3 row d-none" id="el_eol_form">
              <div class="col-sm-5">
                <label class="form-label" for="">
                  Sundays and holidays, if any, proposed to be prefixed/suffixed to leave
                </label>
              </div>
              <div class="col-sm-7">
                <input type="text" name="holiday_date" id="holiday_date"
                value="{{ isset($info->holiday_date) ? date('Y-m-d', strtotime($info->holiday_date)) : '' }}"
                class="form-control">
              </div>
            </div>
            <div class="fv-row form-group mb-3 row">
              <div class="col-sm-5">
                <label class="form-label required" for="">
                  Reason for Leave
                </label>
              </div>
              <div class="col-sm-7">
                <textarea name="reason" id="reason" cols="30" rows="2" class="form-control">{{ $info->reason ?? '' }}</textarea>
              </div>
            </div>
            <div id="leave-form-content">
              @if (isset($info->address) && !empty($info->address) && $type=='approved')
              @include('pages.leave.request_leave.el_form')
              @endif
            </div>

            @if (isset($info) && !empty($info)&& $type=='approved' || $type=='edit')
            <div class="row">
              <div class="col-sm-12">
                <label for="" class="text-warning">
                  Maternity Leave is only applicable for female staff
                </label>
              </div>
              <div class="col-sm-8">
                <h6 class="fs-6 mt-3 alert alert-danger">Total Leave Taken - {{ $leave_count }} &nbsp;&nbsp;&nbsp;  
                  <a href="#" id="taken_data">
                    <i class="fa fa-eye"></i>
                  </a>

                  <h6 class="fs-6 mt-3 alert alert-info">Leave Summary  </h6>
                  <div class="table-wrap table-responsive " style="max-height: 400px;">
                    <table id="nature_table_staff" class="table table-hover table-bordered">
                      <thead class="bg-dark text-white">
                        <tr>
                          <th>Type</th>
                          <th>Allocated</th>
                          <th>Availed</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $staffleavesHead=StaffleaveAllocated($info->staff_info->id,academicYearId());
                        @endphp
                        @if (isset($staffleavesHead) && count($staffleavesHead) > 0)
                        @foreach ($staffleavesHead as $item)
                        <tr>
                          <td>
                            {{ $item->leave_head->name ?? '' }}
                          </td>
                          <td class="text-center">
                            {{ $item->no_of_leave ?? 0 }}
                          </td>
                          @php
                          $carbonDate = \Carbon\Carbon::parse($info->from_date);
                          $took_leaves=leaveData($info->staff_id,$carbonDate->format('Y'),$item->leave_head->name);
                          $balance=$item->no_of_leave - $took_leaves;
                          @endphp
                          <td>{{$took_leaves??'0.00'}}</td>
                          <td>{{number_format($balance,2)??'0.00'}}</td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>

                    </table>
                  </div>
                </div>
                <div class="col-sm-4">

                </div>
              </div>
              @else
              <div class="row" id="leave_approvel">
                <div class="col-sm-12">
                </div>
              </div>
              @endif


            </div>


            <div class="col-sm-6">
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label required mt-3" for="">
                    Name of the Staff
                  </label>
                </div>
                <div class="col-sm-7 position-relative" id="typeahed-click">
                  <input type="text" name="staff_name" value="{{ $info->staff_info->name ?? '' }}"
                  id="staff_name" class="form-control" @if (isset($info->staff_info)) disabled @endif>
                  <span id="input-close" class="d-none">
                    {!! cancelSvg() !!}
                  </span>
                  <input type="hidden" name="staff_id" id="staff_id"
                  value="{{ $info->staff_id ?? '' }}">
                  <div class="typeahead-pane d-none" id="typeadd-panel" style="height: 240px; overflow-y: scroll">
                    <ul type="none" class="typeahead-pane-ul" id="typeahead-list">

                    </ul>
                  </div>
                </div>
              </div>
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label required mt-3" for="">
                    Staff ID
                  </label>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="staff_code"
                  value="{{ $info->staff_info->institute_emp_code ?? '' }}" readonly id="staff_code"
                  class="form-control">
                </div>
              </div>
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label required mt-3" for="">
                    Designation
                  </label>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="designation" value="{{ $info->designation ?? '' }}"
                  readonly id="designation" class="form-control">
                </div>
              </div>
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label " for="">
                    Reporting Manager
                  </label>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="reporting_id" id="reporting_id" class="form-control"
                  readonly value="{{ $info->reporting_info->name ?? '' }}">
                </div>
              </div>
              @if (isset($info) && !empty($info)&& $type=='approved')
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label required" for="">
                    Leave Granted
                  </label>
                </div>
                <div class="col-sm-7">
                  <input type="radio" name="leave_granted" id="leave_granted_yes"
                  value="yes">
                  <label for="leave_granted_yes" role="button"> Yes </label> &emsp;
                  <input type="radio" name="leave_granted" id="leave_granted_no" value="no">
                  <label for="leave_granted_no" role="button"> No </label>
                </div>
              </div>
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label required mt-3" for="">
                    No of Days Granted
                  </label>
                </div>
                <div class="col-sm-7">
                  <input type="number" min="1" max="15" name="no_of_days_granted"
                  id="no_of_days_granted" class="form-control"
                  value="{{number_format($info->granted_days,1)}}" readonly>
                </div>
              </div>

              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label required mt-3" for="">
                    Upload Application
                  </label>
                </div>
                <div class="col-sm-7">
                  <input type="file" name="application_file" id="application_file"
                  class="form-control" required>
                </div>
              </div>
              <div class="fv-row form-group mb-3 row">
                <div class="col-sm-5">
                  <label class="form-label " for="">
                    Remarks
                  </label>
                </div>
                <div class="col-sm-7">
                  <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
                </div>
              </div>
              @endif

              <div class="fv-row form-group mb-3 row"    
              @if( isset( $info->leave_days ))id="new" @else id="grid"  @endif>
              @csrf

              <div class="col-sm-12 tresponse"  @if(isset( $info->leave_days )&& $type=='approved')@else style="padding-left:50px"; @endif>
                @if( isset( $info->leave_days )&& $type=='approved') 
                @php
                $table=json_decode($info->leave_days);
                @endphp
                @if(isset($table[0]->cancell))
                <table class="table table-bordered" >
                  <thead class="bg-dark text-white">
                    <tr>
                      <th scope="col"><b>Date</b></th>
                      <th scope="col">
                        Type
                      </th>
                      <th scope="col"><b>Approved/Reject</b></th>
                      <th scope="col"><b>Cancellation</b></th>
                    </tr>
                  </thead>


                  <tbody>
                    <input type="hidden" value="new" name="type">
                    @foreach(json_decode($info->leave_days) as $key=>$day)

                    <tr>
                      <td>{{ $day->date }}</td>

                      <td style="text-transform: capitalize;">{{$day->type}}</td>
                      <td> {{($day->check==1)? 'Approved': 'Reject'}}</td>
                      <td>
                        @if($day->cancell==1)
                        <label class="toggleSwitch large" onclick="">

                          <input type="checkbox"  id="check" name="leave[cancell][{{$key}}]" value='1'>

                          <span>
                            <span>OFF</span>
                            <span>ON</span>

                          </span>

                        </label>
                        @else

                        -
                      @endif</td>
                    </tr>
                  @endforeach</tbody>
                  <input type="hidden" name="leave_id" value="{{$info->id}}">
                </table>
                @else
                <table class="table table-bordered" >
                  <thead class="bg-dark text-white">
                    <tr>
                      <th scope="col"><b>Date</b></th>
                      <th scope="col">
                        <b>Forenoon</b>&nbsp;&nbsp; <b>Afternoon</b> &nbsp;&nbsp;&nbsp;<b>Both</b>
                      </th>
                      <th scope="col"><b>Approved/Reject</b></th>
                    </tr>
                  </thead>


                  <tbody>
                    <input type="hidden" value="new" name="type">
                    @foreach(json_decode($info->leave_days) as $key=>$day)

                    <tr>
                      <td>{{ $day->date }}</td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="leave[radio][{{$key}}]" value="forenoon"  class="form-check-input" {{ ($day->type=="forenoon")? "checked" : "disabled" }}> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"  name="leave[radio][{{$key}}]"  value="afternoon"  class="form-check-input" {{ ($day->type=="afternoon")? "checked" : "disabled" }}>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"  name="leave[radio][{{$key}}]"  value="both"  class="form-check-input" {{ ($day->type=="both")? "checked" :"disabled" }}> </td> &nbsp;</td>
                      <td><label class="toggleSwitch large" onclick="">
                        <input type="checkbox"  id="check" name="leave[check][{{$key}}]" value='1'>
                        <span>
                          <span>OFF</span>
                          <span>ON</span>

                        </span>

                      </label></td>
                    </tr>
                  @endforeach</tbody>
                </table>
                @endif   



                @elseif($type=='edit')

                <table class="table table-bordered" id="edittable">
                  <thead class="bg-dark text-white">
                    <tr>
                      <th scope="col"><b>Date</b></th>
                      <th scope="col">
                        <b>Forenoon</b>&nbsp;&nbsp; <b>Afternoon</b> &nbsp;&nbsp;&nbsp;<b>Both</b>
                      </th>

                    </tr>
                  </thead>


                  <tbody>
                    <input type="hidden" value="grid" name="type">
                    @if(isset($info->leave_days))
                    @foreach(json_decode($info->leave_days) as $key=>$day)

                    <tr>
                      <td>{{ $day->date }}</td>

                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" id="radio1" name="leave[radio][{{$key}}]" value="forenoon"  class="form-check-input" {{ ($day->type=="forenoon")? "checked" : "" }}> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" id="radio1" name="leave[radio][{{$key}}]"  value="afternoon"  class="form-check-input" {{ ($day->type=="afternoon")? "checked" : "" }}>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="radio1" name="leave[radio][{{$key}}]"  value="both"  class="form-check-input" {{ ($day->type=="both")? "checked" :"" }}> </td> &nbsp;</td>

                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
                @else
                <table class="table table-bordered old_table">
                  <thead class="bg-dark text-white">
                    <tr>
                      <th scope="col"><b>Date</b></th>
                      <th scope="col">
                        <b>Forenoon</b>&nbsp;&nbsp; <b>Afternoon</b> &nbsp;&nbsp;&nbsp;<b>Both</b>
                      </th>

                    </tr>
                  </thead>
                  <input type="hidden" value="grid" name="type">

                  <tbody>
                  </tbody>
                </table>


                @endif
              </div>


            </div>

          </div>
        </div>
        <input type="hidden" name="type" value="{{$type}}">
        <div class="form-group mt-7 text-end">
          <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
          <button type="button" class="btn btn-primary" id="form-submit-btn">
            <span class="indicator-label">
              Submit
            </span>
            <span class="indicator-progress">
              Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
<section class="popup1">
  <div class="popup__content1">
    <div class="close1">
      <span></span>
      <span></span>
    </div>
  </div>
</section>
<section class="popup">
  <div class="popup__content">
    <div class="close">
      <span></span>
      <span></span>
    </div>
    @if( isset( $taken_leave ) && count( $taken_leave ) > 0 )
    <div class="table-wrap table-responsive popupresponse">
      <table id="leave_table_staff" class="table table-hover table-bordered" >
        <thead class="bg-dark text-white">
          <tr>
            <th>
              Date
            </th>
            @if(isset($taken_leave[0]->leave_days) && $taken_leave[0]->leave_days!='')
            <th>
              Day
            </th>
            @endif
            <th>
              Leave Type
            </th>
            <th>
              Leave Category
            </th>

          </tr>
        </thead>
        <tbody>
          @foreach ($taken_leave as $item)
          <tr>
            @if(isset($item->leave_days) && $item->leave_days!='')
            @foreach(json_decode($item->leave_days ?? []) as $key=>$day)
            @if(isset($day->check) && $day->check==1)
            <tr>

              <td >{{date('d/M/Y', strtotime($day->date))}}</td>
              <td >{{($day->type=='both')? 1 :0.5 }}</td>
              <td style="text-transform:capitalize;">{{$day->type}}</td>
              <td>{{ $item->leave_category }}</td>

              <tr>
                @endif
                @endforeach
                @else
                <td>
                  {{ commonDateFormat($item->from_date) .' - '. commonDateFormat($item->to_date) }}
                </td>
                <td>1</td>
                <td>Both</td>
                <td>
                  {{ $item->leave_category }}
                </td>

                @endif

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </section>
    @endsection
    @section('add_on_script')
    <script>
      $("#taken_data").click(function() {
        $(".popup").fadeIn(500);
      });
      $(".close").click(function() {
        $(".popup").fadeOut(500);
      });
      $("#taken_data1").click(function() {
        alert('hi');
        $(".popup1").fadeIn(500);
      });
      $(".close1").click(function() {
        $(".popup1").fadeOut(500);
      });
      function handleEyeIconClick() {
        $(".popup1").fadeIn(500);
      }
      $('input:checkbox').change(function() {
        var formData = $('#new').find('input').serialize();

        $.ajax({
url: "{{ route('get.staff.leave.count') }}", // Replace with your Laravel route
type: 'POST',
data: formData,
dataType: 'json',
success: function(day) {

  if(day==0){

    $('#leave_granted_no').prop('checked', true);


  }else{

    $('#leave_granted_yes').prop('checked', true);

  }

  $('#no_of_days_granted').val(day);
},
error: function(error) {
// Handle any errors here
  console.error('Error:', error);
}
});
      });
      $('#edittable,#radio1').on('change',function() {

        var formData = $('#edittable').find('input').serialize();


        $.ajax({
url: "{{ route('get.staff.leave.count') }}", // Replace with your Laravel route
type: 'POST',
data: formData,
dataType: 'json',
success: function(day) {
//console.log(response);
  $('#no_of_days').val(day);
},
error: function(error) {
// Handle any errors here
  console.error('Error:', error);
}
});
      });
      $('#grid,#radio').on('change',function() {

        var formData = $('#grid').find('input').serialize();


        $.ajax({
url: "{{ route('get.staff.leave.count') }}", // Replace with your Laravel route
type: 'POST',
data: formData,
dataType: 'json',
success: function(day) {
//console.log(response);
  $('#no_of_days').val(day);
},
error: function(error) {
// Handle any errors here
  console.error('Error:', error);
}
});
      });
      $('#leave_category_id').change(function() {
        let leave_category_id = $(this).val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: "{{ route('get.leave.form') }}",
          type: 'POST',
          data: {
            leave_category_id: leave_category_id,
          },
          success: function(res) {
            if (res) {
              $('#leave-form-content').html(res);
            } else {
              $('#leave-form-content').html('');
              $('#el_eol_form').addClass('d-none');
            }
          }
        })
      })
      window.addEventListener('click', function(e) {
        if (document.getElementById('typeahed-click').contains(e.target)) {
// Clicked in box
        } else {
// Clicked outside the box
          $('#typeadd-panel').addClass('d-none');
// $('#staff_name').val('');
// $('#staff_id').val('');
// $('#staff_code').val('');
// $('#designation').val('');
        }
      });

      var staff_name = document.getElementById('staff_name');

      staff_name.addEventListener('keyup', function() {

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: "{{ route('get.staff') }}",
          type: 'POST',
          data: {
            query: this.value,
          },
          success: function(res) {
            console.log(res);
            if (res && res.length > 0) {
              $('#typeadd-panel').removeClass('d-none');
              let panel = '';
              res.map((item) => {
                panel +=
                `<li class="typeahead-pane-li" onclick="return getStaffLeaveInfo(${item.id})">${item.name} - ${item.institute_emp_code}</li>`;
              })
              $('#typeahead-list').html(panel);

            } else {
              $('#typeadd-panel').addClass('d-none');

            }
          }
        })
      })

      function getStaffLeaveInfo(staff_id) {   
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: "{{ route('get.staff.leave.info') }}",
          type: 'POST',
          data: {
            staff_id: staff_id,
          },
          success: function(res) {

            if (res.data) {
              $('#staff_code').val(res.data.institute_emp_code);
              $('#designation').val(res.data?.position?.designation?.name);
              $('#staff_id').val(res.data.id);
              $('#staff_name').val(res.data.name);
              $('#typeadd-panel').addClass('d-none');
//$('#staff_name').attr('disabled', true);
              $('#input-close').removeClass('d-none');
              $('#reporting_id').val(res.data?.reporting?.name);
              var tabledata = $('#leave_approvel');
              tabledata.append('');
              let row='<label for="" class="text-warning">Maternity Leave is only applicable for female staff</label></div><div class="col-sm-8"><h6 class="fs-6 mt-3 alert alert-danger">Total Leave Taken - 0 &nbsp;&nbsp;&nbsp;  <a href="#" id="taken_data1"><i class="fa fa-eye"></i></a><h6 class="fs-6 mt-3 alert alert-info">Leave Summary</h6><div class="table-wrap table-responsive " style="max-height: 400px;"><table id="nature_table_staff" class="table table-hover table-bordered"><thead class="bg-dark text-white"><tr><th>Type</th><th>Allocated</th><th>Availed</th></tr></thead><tbody><tr><td>1</td><td class="text-center">2</td><td>0.00</td></tr></tbody></table></div></div><div class="col-sm-4">';
              tabledata.append(row);
              tabledata.on('click', '#taken_data1', handleEyeIconClick);

            }
          }
        })
      }
      $('#input-close').click(function() {

        $('#staff_code').val('');
        $('#designation').val('');
        $('#staff_id').val('');
        $('#staff_name').val('');
        $('#typeadd-panel').removeClass('d-none');
        $('#staff_name').attr('disabled', false);
        $('#input-close').addClass('d-none');
        $('#reporting_id').val('');
      })


      function datediff(first, second) {
        return Math.round((second - first) / (1000 * 60 * 60 * 24));
      }

      function parseDate(str) {
        var dmy = str.split('/');
        return new Date(dmy[2], dmy[1] - 1, dmy[0]);
      }



      function getStaffLeaveDays(staff_id_alt, start_date, end_date,leave_type) {  
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $("#grid tbody").empty();
        $.ajax({
          url: "{{ route('get.staff.leave.available') }}",
          type: 'POST',
          data: {
            staff_id: staff_id_alt,
            leave_start: start_date,
            leave_end: end_date,
            leave_type: leave_type
          },
          success: function(response) {

            $('#edittable').hide("");
            $('#grid').show("slow");
            var tableBody = $('#grid tbody');

            $.each(response.total_days, function(index, item) {
              var row = '<tr>' +
              '<td>' + item + '<input type="hidden" name="leave[date]['+ index +']" value="'+ item +'"> </td>' +
              '<td>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" id="radio" name="leave[radio]['+ index +']" value="forenoon"  class="form-check-input" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"  name="leave[radio]['+ index +']"  value="afternoon"  class="form-check-input" id="radio">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"  name="leave[radio]['+ index +']"  value="both"  class="form-check-input" id="radio"> </td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' +
              '</tr>';
              tableBody.append(row);
            });

          }
        })
      }

      $(function() {

        $('input[name="requested_date"]').daterangepicker({
          autoUpdateInput: false,
          locale: {
            cancelLabel: 'Clear'
          },
          // minDate: moment().startOf('day')
        });

        $('input[name="requested_date"]').on('apply.daterangepicker', function(ev, picker) {

          $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
            'DD/MM/YYYY'));

          let start_date = picker.startDate.format('DD/MM/YYYY');
          let end_date = picker.endDate.format('DD/MM/YYYY');

          let requested_days = datediff(parseDate(start_date), parseDate(end_date));
//$('#no_of_days').val(requested_days + 1);
      var staff_id_alt =$('#staff_id').val();
      var leave_type =document.getElementById("leave_category_id").value;
          getStaffLeaveDays(staff_id_alt, picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'),leave_type)
        });

        $('input[name="requested_date"]').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
        });

        $('input[name="holiday_date"]').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          minYear: 1901,
          autoUpdateInput: false,
          locale: {
            cancelLabel: 'Clear'
          }
        });

        $('input[name="holiday_date"]').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        $('input[name="holiday_date"]').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
        });


      });
      var KTAppEcommerceSaveBranch = function() {

        const handleSubmit = () => {

          let validator;
          const Leave_list = "{{ route('leaves.list') }}";
          const form = document.getElementById('leave_form');
          const submitButton = document.getElementById('form-submit-btn');

          validator = FormValidation.formValidation(
            form, {
              fields: {
                'leave_category_id': {
                  validators: {
                    notEmpty: {
                      message: 'Leave Category is required'
                    },
                  }
                },
                'staff_name': {
                  validators: {
                    notEmpty: {
                      message: 'Staff Name is required'
                    },
                  }
                },
                'staff_code': {
                  validators: {
                    notEmpty: {
                      message: 'Staff ID is required'
                    },
                  }
                },
                'designation': {
                  validators: {
                    notEmpty: {
                      message: 'Designation is required'
                    },
                  }
                },
                'requested_date': {
                  validators: {
                    notEmpty: {
                      message: 'Request Date is required'
                    },
                  }
                },
                'reason': {
                  validators: {
                    notEmpty: {
                      message: 'Reason is required'
                    },
                  }
                },
              },
              plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                  rowSelector: '.fv-row',
                  eleInvalidClass: '',
                  eleValidClass: ''
                })
              }
            }
            );

// Handle submit button
          submitButton.addEventListener('click', e => {
            e.preventDefault();
// Validate form before submit
            if (validator) {
              validator.validate().then(function(status) {

                if (status == 'Valid') {
                  submitButton.disabled = true;
                  var forms = $('#leave_form')[0];
                  var formData = new FormData(forms);
                  $.ajax({
                    url: "{{ route('save.leaves') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
// Disable submit button whilst loading
                      submitButton.disabled = false;
                      submitButton.removeAttribute(
                        'data-kt-indicator');
                      if (res.error == 1) {
                        if (res.message) {
                          res.message.forEach(element => {
                            toastr.error("Error",
                              element);
                          });
                        }
                      } else {
                        if(res.type==''){
                          toastr.success(
                            "Leave Request added successfully");  
                        }else{
                          toastr.success(
                            "Leave Request updated successfully");
                        }

                        window.location.href = Leave_list;
                        dtTable.draw();
                      }
                    }
                  })

                }
              });
            }
          })
        }

        return {
          init: function() {
            handleSubmit();
          }
        };
      }();

      KTUtil.onDOMContentLoaded(function() {
        KTAppEcommerceSaveBranch.init();
      });
    </script>
    @endsection
