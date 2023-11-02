@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
<style>
body {
  font-family: "Poppins";
  background:#f0f4f7;
}
.sidebar {
  height: 100%;
  width: 265px;
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #ffffff;
  padding-top: 16px;
  overflow-x: hidden;
}

.sidebar a {
  padding: 15px 8px 6px 16px;
  text-decoration: none;
  font-size: 15px;
  color: #818181;
  display: block;
}
.sidebar a span{
  font-size: 15px;
  padding-right:20px;

}
.sidebar a:hover {
    color: #083C90;
}
.sidebar img{
  width:50%;
  display: block;
  margin:0 auto;
}
.main {
  margin-left: 276px; /* Same as the width of the sidenav */
  padding: 0px 10px;
  background-color:#f0f4f7;
}
.main-sub{
  background-color:white;
  padding: 20px;
  margin-bottom: 45px;
}
.sidebar h4{
  text-align: center;
 
}

.main-sub th{
    color: #083C90;
}
.main-sub th{
  text-align: left;
  padding: 16px 100px 0px 0px;
}
.main-sub td{

 
}
.btn-close
{
    padding: 10px 20px;
    background: #FCD9E2;
    border: #FCD9E2;
    color: #F1416C;
    font-size: 20px;
    width: 59px;
  margin: 0px -4px;
  height: 42px;
  padding: 3px 20px;
  border-radius: 3px;
}
.btn-save{
  padding: 10px 20px;
    background: #dbf5e8;
    border: #dbf5e8;
    color: #50CD89;
    font-size: 20px;
  margin-left: 25px;
}
.sidebar i{
  padding-right: 10px;
  
}
.border-style-cs ul{
  display: flex;
  list-style: none;
  margin:0px;

}
.border-style-cs ul li{
  /* margin-right:20px; */
}
.fa-times:before {
    content: "\f00d";
    color: #d13333;
}
.fa-check-square-o:before {
    content: "\f046";
    color: #00C389;
}
.fa-cloud-download:before {
    content: "\f0ed";
    color: #009EF7;
}
.mange-alloance-section table{
  background: #ffffff;
  padding: 20px;
}
.mange-alloance-section th, .mange-alloance-section td {
  text-align: left;
 
}
.mange-alloance-section td{
  padding-left: 100px;
  padding-right:150px;
}
.lt-btn {
    background-color: #2fb4ff21;
    color: #009EF7;
    border: #2FB4FF;
    padding: 10px 25px;
    border-radius: 4px;
    font-size: 18px;
}
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
table {
  border-collapse: collapse;
}

tr{
  border-bottom: 1px solid #F4F4F4;
}
#quantity
{
    background: #bebcbc;
    border: #bebcbc;
    padding: 10px 8px;
    margin: 10px;
    text-align: center;
    width:50px;
    border-radius:4px;
}
#quantity2{
    background: #2fb4ff70;
    border: #2fb4ff70;
    padding: 10px 8px;
    margin: 10px;
    text-align: center;
    width:50px;
    border-radius:4px;
}
.modal-dialog {
    width: 100%;
    margin: 30px auto !important;
}
.sidebar svg{
  padding-right: 12px;
}
.btn-back {
  float: right;
  margin: 30px;
  border: 0px;
  background: #e4f5ff;
  padding: 10px 25px;
}
.badge{
   background: #2fb4ff26;
margin: 16px;
padding: 11px;
color: #009ef7;
font-weight: 600;
border-radius: 5px; 
}
.badge1{
   background: #ebebeb;
margin: 16px;
padding: 11px;
color: #7C7C7C;
font-weight: 600;
border-radius: 5px; 
}
</style>
  <div class="card mb-2">
    <div class="modal-content">
      <div class="modal-header">
       
     
      </div>
      <div class="modal-body">
        <div class="sidebar">
           @php
$profile_image=storage_path('app/public/' . $staff->image); @endphp
@if (file_exists($profile_image))
  <img src="{{ asset('storage/app/public/' .$item->user->image) }}" >
@else
  <img src="{{url('assets/logo/profile.png')}}">
@endif
        
          <h4>{{$staff->name}}</h4>
          <a href="#" style="text-transform: capitalize;"><i class="fa fa-fw fa-user"></i>{{$staff->personal->gender?? ''}}</a>
          <a href="#" style="text-transform: capitalize;"><i class="fas fa-user-circle"></i>{{$staff->appointment->staffCategory->name?? ''}}</a>
          <a href="#"><i class="fas fa-map-marker-alt"></i>{{$staff->personal->contact_address?? ''}}</a>
          <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>{{$staff->personal->phone_no?? ''}}</a>
          <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> {{$staff->personal->dob?? ''}}</a>
          <a href="#"><i class="fa fa-fw fa-envelope"></i> {{$staff->personal->email?? ''}}</a>
          <a href="#"><span>Employe ID</span> {{$staff->institute_emp_code?? ''}}</a>
          <a href="#"><span>Reporting Person</span>{{$staff->reporting->name ?? ''}}</a>
          <a href="#"><span>Marital Status</span> {{$staff->reporting->marital_status ?? ''}}</a>
          <a href="#"><span>Employee Type</span> {{$staff->appointment->employment_nature->name ?? ''}}</a>
          <a href="#"><span>Employee Since</span> 2010</a>
          {{-- <a href="#"><button class="btn-close">Close</button><button class="btn-save">Save</button></a> --}}
          
        </div>
        
        <div class="main">
          <a href="{{url('leaves/overview/list')}}"><button class="btn-back">back</button></a>
          <h1 style=" padding-top:25px;
          padding-bottom: 25px;">Manage Leaves </h1> 
          <div class="main-sub">
          <h3>Leave Request</h3>
          <div style="overflow-x:auto;">
            <table>
              <tr>
                <th>From Date</th>
                <th>To Date</th>
                <th style="text-align: center;">Remarks</th>
                <th colspan="3">Leave Type</th>
                <th >Action</th>   
              </tr>
              @foreach($total as $data)
              <tr class="border-style-cs">
                <td>{{$data->from_date}}</td>
                <td>{{$data->to_date}}</td>
                <td><button style="background: #f1f4f6 !important;border-radius: 3px;border: 0px;padding: 10px;margin: 10px;">{{$data->reason}}</button></td>
                <td>{{$data->leave_category}}</td>
                <td>
                  <ul><li><a href="{{asset('storage/app/public/'.$data->approved_document) }}" tooltip="Approved Document" target="_blank"  class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a></li>
                  <li><a href="{{asset('storage/app/public/'.$data->document) }}" tooltip="Approved Document" target="_blank"  class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px"> <i class="fa fa-download"></i>
                            </a> </li>
                </ul>
                </td>
              </tr>
              @endforeach
            </table>
          </div>
            {{ $total->links('pagination::bootstrap-4') }}
          </div>
          <div class="mange-alloance-section">
            
            <table>
              <tr>
                {{-- <th><h3>Manage Leave Allowance</h3></th>
                <th><button class="lt-btn">Add a Leave Type</button></th> --}}
              </tr>
              @foreach($leavehead as $total)
              <tr>
                <td style="text-transform: uppercase;">{{$total->name ?? ''}}</td> 
                <td><span class="badge1"> {{$total->leave_day->leave_days?? 0}}</span> of <span class="badge"> {{$total->count ?? 0}}</span></td>    
            </tr>
            @endforeach
            </table>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
@endsection
