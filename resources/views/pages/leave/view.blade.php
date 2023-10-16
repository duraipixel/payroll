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
.main-sub th, .main-sub td {
  text-align: center;
  padding: 16px 10px;

}
.btn-close
{
    padding: 10px 20px;
    background: #FCD9E2;
    border: #FCD9E2;
    color: #F1416C;
    font-size: 20px;
}
.btn-save{
  padding: 10px 20px;
    background: #dbf5e8;
    border: #dbf5e8;
    color: #50CD89;
    font-size: 20px;
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
  margin-right:20px;
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
  padding: 10px 10px;

}
.lt-btn {
    background-color: #2fb4ff70;
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
    padding: 15px 2px;
    margin: 10px;
    text-align: center;
}
#quantity2{
    background: #2fb4ff70;
    border: #2fb4ff70;
    padding: 15px 2px;
    margin: 10px;
    text-align: center;
}
.modal-dialog {
    width: 100%;
    margin: 30px auto !important;
}
</style>
  <div class="card mb-2">
    <div class="modal-content">
      <div class="modal-header">
       
       
      </div>
      <div class="modal-body">
        <div class="sidebar">
          <img src="{{url('assets/logo/profile.png')}}">
          <h4>John Joe</h4>
          <a href="#"><i class="fa fa-fw fa-user"></i>Male</a>
          <a href="#"><i class="fa fa-user-circle-o" aria-hidden="true"></i></i>Teacher</a>
          <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>1554555478</a>
          <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> 18-02-2023</a>
          <a href="#"><i class="fa fa-fw fa-envelope"></i> max@kt.com</a>
          <a href="#"><span>Employe ID</span> AM156820</a>
          <a href="#"><span>Reporting Person</span> Smith</a>
          <a href="#"><span>Marital Status</span> AM156820</a>
          <a href="#"><span>Employee Type</span> AM156820</a>
          <a href="#"><span>Employee Since</span> 2010</a>
          <a href="#"><span><button class="btn-close">Close</button></span><button class="btn-save">Save</button></a>
          
        </div>
        
        <div class="main">
          <h1>Manage Leaves </h1> 
          <div class="main-sub">
          <h3>Leave Request</h3>
          <div style="overflow-x:auto;">
            <table>
              <tr>
                <th>From Date</th>
                <th>To Date</th>
                <th>Remarks</th>
                <th colspan="3">Leave Type</th>
                <th>Action</th>   
              </tr>
              <tr class="border-style-cs">
                <td>Feb 02 2023</td>
                <td>Feb 12 2023</td>
                <td style="background: #f1f4f6 !important;border-radius: 16px;">Lorem ipsum dolor sit amet, consectetur</td>
                <td>Casual Leave</td>
                <td>
                  <ul><li><i class="fa fa-cloud-download" aria-hidden="true"></i></li>
                  <li><i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                  <li><i class="fa fa-times" aria-hidden="true"></i></li></ul>
                </td>
              </tr>
            </table>
          </div>
          </div>
          <div class="mange-alloance-section">
            
            <table>
              <tr>
                <th><h3>Manage Leave Allowance</h3></th>
                <th><button class="lt-btn">Add a Leave Type</button></th>
              </tr>
              <tr>
                <td>Casual Leave</td> 
                <td><input type="number" id="quantity" name="quantity" min="1" max="20">of <input type="number" id="quantity2" name="quantity" min="1" max="20"></td>    
              </tr>
              <tr>
                <td>Earned Leave</td>
                <td><input type="number" id="quantity" name="quantity" min="1" max="20">of <input type="number" id="quantity2" name="quantity" min="1" max="20"></td>    
              </tr>
              <tr>
                <td>COVID Leave</td>
                <td><input type="number" id="quantity" name="quantity" min="1" max="20">of <input type="number" id="quantity2" name="quantity" min="1" max="20"></td>    
              </tr>
              <tr>
                <td>Maternity Leave</td>
                <td><input type="number" id="quantity" name="quantity" min="1" max="20">of <input type="number" id="quantity" name="quantity" min="1" max="20"></td>    
              </tr>
              <tr>
                <td>Loss of Pay</td>
                <td><input type="number" id="quantity" name="quantity" min="1" max="20">of <input type="number" id="quantity2" name="quantity" min="1" max="20"></td>    
              </tr>
              <tr>
                <td>Extended Leave</td>
                <td><input type="number" id="quantity" name="quantity" min="1" max="20">of <input type="number" id="quantity2" name="quantity" min="1" max="20"></td>    
              </tr>
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
