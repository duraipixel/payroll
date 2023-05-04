<!--begin::Navbar-->
@extends('layouts.template')
@section('content')
    <!--begin::Card-->
    <div class="card">
<?php
   $master_menu = config('services.master_menu');
   $staff_management = config('services.staff_management');
?>
        <div class="card-body py-4">
            <!--begin::Table-->
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
               
                <div class="row">
                      
        <div class="container">
            <div class="col-12 pb-3">
               <h4> <strong>Master Menu</strong>
                <input type="checkbox"  name="master_select_all" id="master_select_all" onclick="master_select_all_func();"></h4>
              </div>
              <div class="row justify-content-start">                     
                <div class="row mb-6">
                    <div class="col-1">
                        <b>Sl.No</b>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5">
                        <strong>Menu</strong>
                    </div>
                    <div class="col-1">
                        <strong>Add</strong>
                    </div>
                    <div class="col-1">
                        <strong> Edit</strong>
                    </div>
                    <div class="col-1">
                        <strong>View</strong>
                    </div>
                    <div class="col-1">
                        <strong>Delete</strong>
                    </div>
                    <div class="col-1">
                        <strong>Export</strong>
                    </div> 
                </div>
                @php
                    $i=1;
                    $master_row=0;
                @endphp
                @foreach($master_menu as $key => $master_menus)               
                <div class="row mb-6"> 
                    <div class="col-1">
                        {{ $i}}
                    </div>
                    <div class="col-1">
                        <input type="checkbox" class="master_checkox" name="select_all_row_wise_{{$i}}" id="select_all_row_wise_{{$i}}" onclick="master_row({{$i}});">
                    </div>
                    <div class="col-5">                  
                    <span class="pl-3"> {{$master_menus}}</span>
                    <input type="hidden" name="menu_name[]" id="menu_name" value="{{$key}}">                   
                    </div>
                    <div class="col-1">
                        <input type="checkbox" class="master_checkox" name="master_add[]" id="master_add_{{$i}}">
                    </div>
                    <div class="col-1">
                        <input type="checkbox" class="master_checkox" name="master_edit[]" id="master_edit_{{$i}}" >
                    </div>
                    <div class="col-1">
                        <input type="checkbox" class="master_checkox" name="master_view[]" id="master_view_{{$i}}">
                    </div>
                    <div class="col-1">
                        <input type="checkbox" class="master_checkox" name="master_delete[]" id="master_delete_{{$i}}">
                    </div>
                    <div class="col-1">
                        <input type="checkbox" class="master_checkox" name="master_export[]" id="master_export_{{$i}}">
                    </div>    
                </div>
            @php
            $i++;
            $master_row++;
            @endphp           
            @endforeach
            <input type="hidden" name="master_row_count" id="master_row_count" value="{{$master_row}}">
                    </div> 
                    
                    <div class="col-12 pb-3">
                        <h4> <strong>Staff Management</strong>
                         <input type="checkbox"  name="staff_select_all" id="staff_select_all" onclick="staff_select_all_func();"></h4>
                       </div>
                       <div class="row justify-content-start">                     
                         <div class="row mb-6">
                             <div class="col-1">
                                 <b>Sl.No</b>
                             </div>
                             <div class="col-1"></div>
                             <div class="col-5">
                                 <strong>Menu</strong>
                             </div>
                             <div class="col-1">
                                 <strong>Add</strong>
                             </div>
                             <div class="col-1">
                                 <strong> Edit</strong>
                             </div>
                             <div class="col-1">
                                 <strong>View</strong>
                             </div>
                             <div class="col-1">
                                 <strong>Delete</strong>
                             </div>
                             <div class="col-1">
                                 <strong>Export</strong>
                             </div> 
                         </div>
                         @php
                             $si=1;
                             $staff_row=0;
                         @endphp
                         @foreach($staff_management as $key => $staff_managements)               
                         <div class="row mb-6"> 
                             <div class="col-1">
                                 {{ $si}}
                             </div>
                             <div class="col-1">
                                 <input type="checkbox" class="master_checkox" name="select_all_row_wise_{{$i}}" id="select_all_row_wise_{{$i}}" onclick="master_row({{$i}});">
                             </div>
                             <div class="col-5">                  
                             <span class="pl-3"> {{$staff_managements}}</span>
                             <input type="hidden" name="staff_menu_name[]" id="staff_menu_name" value="{{$key}}">                   
                             </div>
                             <div class="col-1">
                                 <input type="checkbox" class="staff_checkox" name="staff_add[]" id="staff_add_{{$si}}">
                             </div>
                             <div class="col-1">
                                 <input type="checkbox" class="staff_checkox" name="staff_edit[]" id="staff_edit_{{$si}}" >
                             </div>
                             <div class="col-1">
                                 <input type="checkbox" class="staff_checkox" name="staff_view[]" id="staff_view_{{$si}}">
                             </div>
                             <div class="col-1">
                                 <input type="checkbox" class="staff_checkox" name="staff_delete[]" id="staff_delete_{{$si}}">
                             </div>
                             <div class="col-1">
                                 <input type="checkbox" class="staff_checkox" name="staff_export[]" id="staff_export_{{$si}}">
                             </div>    
                         </div>
                     @php
                     $si++;
                     $master_row++;
                     @endphp           
                     @endforeach
                     <input type="hidden" name="staff_row_count" id="staff_row_count" value="{{$master_row}}">
                </div> 
                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection
@section('add_on_script')
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    function master_row(i)
    {
        var select_all_row_wise = document.getElementById("select_all_row_wise_"+i);
        if (select_all_row_wise.checked == true)
        {
            document.getElementById("master_add_"+i).checked = true;
            document.getElementById("master_edit_"+i).checked = true;
            document.getElementById("master_view_"+i).checked = true;
            document.getElementById("master_delete_"+i).checked = true;
            document.getElementById("master_export_"+i).checked = true;
        }
        else
        {
            console.log('row wise uncheck');
            document.getElementById("master_add_"+i).checked = false;
            document.getElementById("master_edit_"+i).checked = false;
            document.getElementById("master_view_"+i).checked = false;
            document.getElementById("master_delete_"+i).checked = false;
            document.getElementById("master_export_"+i).checked = false;
            $("#master_select_all").prop("checked", false);
           
        }
    }

    function master_select_all_func()
    {
        var master_selectall = document.getElementById("master_select_all");
        var row_count = $("#master_row_count").val();
        if (master_selectall.checked == true)
        {
            for (let i = 1; i <= row_count; i++) 
            {  
                document.getElementById("select_all_row_wise_"+i).checked = true;            
                document.getElementById("master_add_"+i).checked = true;
                document.getElementById("master_edit_"+i).checked = true;
                document.getElementById("master_view_"+i).checked = true;
                document.getElementById("master_delete_"+i).checked = true;
                document.getElementById("master_export_"+i).checked = true;
            }
        }
        else
        {
            for (let j = 1; j <= row_count; j++) 
            {
                document.getElementById("select_all_row_wise_"+j).checked = false;
                document.getElementById("master_add_"+j).checked = false;
                document.getElementById("master_edit_"+j).checked = false;
                document.getElementById("master_view_"+j).checked = false;
                document.getElementById("master_delete_"+j).checked = false;
                document.getElementById("master_export_"+j).checked = false;
            }
        }
    }
    
$( document ).ready(function() {
    $('.master_checkox').click(function() {
        var row_count = $("#master_row_count").val();
        for (let k = 1; k <= row_count; k++) 
        {
            if((document.getElementById("master_add_"+k).checked == false) || (document.getElementById("master_edit_"+k).checked == false)
            || (document.getElementById("master_view_"+k).checked == false) || (document.getElementById("master_delete_"+k).checked == false)
            || (document.getElementById("master_export_"+k).checked == false))
            {
                document.getElementById("select_all_row_wise_"+k).checked = false;
                document.getElementById("master_select_all").checked = false; 
            }
            else if((document.getElementById("master_add_"+k).checked == true) &&  (document.getElementById("master_edit_"+k).checked == true)
            && (document.getElementById("master_view_"+k).checked == true) && (document.getElementById("master_delete_"+k).checked == true)
            && (document.getElementById("master_export_"+k).checked == true))
            {
                document.getElementById("select_all_row_wise_"+k).checked = true;
                document.getElementById("master_select_all").checked = true;
            }         
        }
    });
});
</script>