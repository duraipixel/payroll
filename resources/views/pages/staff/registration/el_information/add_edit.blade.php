@if($type=='edit')
<div class="fv-row form-group mb-10"> 
   
    <form name="add_name" id="add_name">
         <input type="hidden" name="staff_id" value="{{ $info->staff_id ?? '' }}">
         <input type="hidden" name="leave_mapping_id" value="{{ $info->id ?? '' }}">
         <input type="hidden" name="academic_id" value="{{ $info->acadamic_id?? '' }}">
          <input type="hidden" name="calendar_id" value="{{$info->calender_id ?? '' }}">
        <table class="table table-bordered table-hover" id="dynamic_field">
            <tr>
                <td><input type="date" name="from_date[]" placeholder="Enter From Date" class="form-control name_list" id="selected_date"/></td>
                <td><input type="date" name="to_date[]" placeholder="Enter To Date" class="form-control name_email"/></td>
                <td><input type="number" name="availed[]" value="" placeholder="Leave" class="form-control total_amount"/></td>
                <td><input type="text" name="remarks[]" value="" placeholder="Enter Remarks" class="form-control total_amount"/></td>
                <td><button type="button" name="add" id="add" class="btn btn-primary">Add</button></td>  
            </tr>
        </table>
        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit">
    </form>
</div>
@else
<div class="fv-row form-group mb-10"> 
    <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">

        <thead>
            <tr class="fw-bolder text-muted">
                <th class="min-w-50px">From Date</th>
                <th class="min-w-120px">To Date</th>
                <th class="min-w-120px">Leave Days</th>
                <th class="min-w-120px">Remarks</th>
                <th class="min-w-120px">Action</th>
            </tr>
        </thead>

        <tbody>
            @if(count($info->elentries)>0)
            @foreach($info->elentries as $elentry )
            <tr>
                <td class="text-dark fw-bolder text-hover-primary fs-6">
                    {{ date('d-M-Y',strtotime($elentry->from_date))}}
                </td>

                <td class="text-dark fw-bolder text-hover-primary fs-6">
                     {{ date('d-M-Y',strtotime($elentry->to_date))}}
                  
                </td>
                <td class="text-dark fw-bolder text-hover-primary fs-6">
                    {{$elentry->leave_days}}

                </td>
                <td class="text-dark fw-bolder text-hover-primary fs-6">
                    {{$elentry->remarks}}

                </td>
                <td class="text-dark fw-bolder text-hover-primary fs-6">
                  <a href="javascript:void(0);" onclick="deleteLeave({{$elentry->id}})" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px"> 
                                <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"></path></svg></a>

                </td>
            </tr>
            
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endif
<script>
   
      $(document).ready(function(){
   
  var i = 1;
    var length;
   var addamount = 700;

  $("#add").click(function(){
     addamount += 700;
     console.log('amount: ' + addamount);
   i++;
      $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="date" name="from_date[]" placeholder="Enter From Date" class="form-control name_list"/></td><td><input type="date" name="to_date[]" placeholder="Enter To Date" class="form-control name_email"/></td> <td><input type="number" name="availed[]" value="" placeholder="Leave" class="form-control total_amount"/> <td><input type="text" name="remarks[]" value="" placeholder="Enter Remarks" class="form-control total_amount"/></td></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
    });

  $(document).on('click', '.btn_remove', function(){  
    addamount -= 700;
    console.log('amount: ' + addamount);
     
      var button_id = $(this).attr("id");     
      $('#row'+button_id+'').remove();  
    });
    


    $("#submit").on('click',function(event){
    var formdata = $("#add_name").serialize();
      event.preventDefault()
        $("#submit").attr("disabled", 'disabled');
      $.ajax({
        url   :"{{route('staff.el.summary.update')}}",
        type  :"POST",
        data  :formdata,
        cache :false,
        success:function(result){
          $("#add_name")[0].reset();
          toastr.success("El Leave added successfully");
        $("#submit").removeAttr("disabled");
        dtTable.draw();
        },error: function(xhr, err) {
        $("#submit").removeAttr("disabled");         
        }
      });
      
    });
  });
   function deleteLeave( id = '') {
       if (confirm('Are you sure you want to delete this leave?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('staff.el.summary.delete') }}",
                type: 'POST',
                data: {
                    id: id,
                  
                    
                },
                success: function(res) {
            $('#kt_dynamic_app').modal('hide');
            $('#kt_dynamic_app').modal('show');
            toastr.success("El Leave deleted successfully");
            dtTable.draw();
                }
            })
        }

        }
    
    
</script>