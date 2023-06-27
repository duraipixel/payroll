<div class="row">
    <div class="col-sm-12">
        <div class="d-flex justify-content-between">
            <div class="from-group">
                <label> Other Income </label>
            </div>
            <div class="from-group">
                <button type="button" class="btn btn-primary btn-sm"> Add New </button>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <table class="w-100 mt-5 border border-2" id="deduction_table">
            <thead class="bg-primary text-white p-4">
                <tr>
                    <th class="p-2"> Description </th>
                    <th class="p-2"> Amount (P.A) </th>
                    <th class="p-2"> Remarks </th>
                    <th class="p-2"> Action </th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 3; $i++)
                    <tr>
                        <td class="p-2">
                            <input type="text" name="amount[]" class="form-input">
                        </td>
                        <td class="p-2">
                            <input type="text" name="amount[]" class="form-input">
                        </td>
                        <td class="p-2">
                            <input type="text" name="remarks[]" class="form-input">
                        </td>
                        <td class="p-2 text-center">
                            <i class="fa fa-trash p-2 text-danger"></i>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="col-sm-12 text-end mt-3">
        <button class="btn btn-dark btn-sm" type="button"> cancel </button>
        <button class="btn btn-success btn-sm" type="button"> Save </button>
    </div>
</div>