<form name="add_el" id="add_el">
         <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
         <lavel style="font-weight:bold">EL Granted</label>
        <input type="number" name="el_granted" placeholder="Enter EL Granted" class="form-control" value="{{ $info->no_of_leave ?? '' }}"/>
        <br>
        <button type="button" class="btn btn-success" name="submit" id="el_submit">SAVE</button>
</form>
<script>
 $(document).ready(function() {
    $('#el_submit').click(function() {
    var formdata = $("#add_el").serialize();
      event.preventDefault()
        $("#submit").attr("disabled", 'disabled');
      $.ajax({
        url   :"{{route('staff.el.add')}}",
        type  :"POST",
        data  :formdata,
        cache :false,
        success:function(result){
          $("#add_el")[0].reset();
          $('#kt_dynamic_app').modal('hide');
          toastr.success("El Updated successfully");
        $("#el_submit").removeAttr("disabled");
            dtTable.draw();
        },error: function(xhr, err) {
        $("#el_submit").removeAttr("disabled");         
        }
      });
      
    });
});
 </script>