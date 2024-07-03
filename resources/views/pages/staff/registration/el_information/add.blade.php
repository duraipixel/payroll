<form name="add_el" id="add_el">
         <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
         <lavel style="font-weight:bold">EL Granted</label>
        <input type="number" name="el_granted" placeholder="Enter EL Granted" class="form-control" value="{{ $info->no_of_leave_actual ?? '' }}"/>
        <br>
        <input type="submit" class="btn btn-success" name="submit" id="el_submit" value="Submit">
</form>