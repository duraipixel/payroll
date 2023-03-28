<!--begin::Navbar-->
@extends('layouts.template')
@section('content')
    <!--begin::Card-->
    <div class="card">
<?php
   $master_menu = config('services.master_menu');
   
?>
        <div class="card-body py-4">
            <!--begin::Table-->
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
               
                <div class="row">
                      
        <div class="container">
            <div class="col-12 pb-3">
               <h4> <strong>Master Menu</strong>
                <input type="checkbox" name="master_select_all" id="master_select_all"></h4>
              </div>
              <div class="row justify-content-start">        
             
                   
                <div class="row mb-6">
                    <div class="col-1">
                    </div>
                <div class="col-6">
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
                @endphp
                @foreach($master_menu as $key => $master_menus)
               
                <div class="row mb-6"> 
                    <div class="col-1">
                        <input type="checkbox" name="select_all_{{$i}}" id="select_all_{{$i}}">
                    </div>
                <div class="col-6">
                  
                   <span class="pl-3"> {{$master_menus}}</span>
                   <input type="hidden" name="menu_name[]" id="menu_name" value="{{$key}}">
                   
                </div>
                <div class="col-1">
                    <input type="checkbox" name="master_add[]" id="master_add_{{$i}}">
                </div>
                <div class="col-1">
                    <input type="checkbox" name="master_edit[]" id="master_edit_{{$i}}">
                </div>
                <div class="col-1">
                    <input type="checkbox" name="master_view[]" id="master_view_{{$i}}">
                </div>
                <div class="col-1">
                    <input type="checkbox" name="master_delete[]" id="master_delete_{{$i}}">
                </div>
                <div class="col-1">
                    <input type="checkbox" name="master_export[]" id="master_export_{{$i}}">
                </div>    
            </div>
            @php
            $i++;
            @endphp
            @endforeach
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
