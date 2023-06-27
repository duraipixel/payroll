<div class="row">
    <div class="col-sm-12">
        <div class="d-flex justify-content-between">
            <div class="from-group">
                <label> Tax Related Component </label>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <table class="w-100 mt-5 border border-2" id="deduction_table">
            <thead class="bg-primary text-white p-4">
                <tr>
                    <th class="p-2"> Component </th>
                    <th class="p-2"> Total </th>
                    <th class="p-2"> Apr </th>
                    <th class="p-2"> May </th>
                    <th class="p-2"> Jun </th>
                    <th class="p-2"> Jul </th>
                    <th class="p-2"> Aug </th>
                    <th class="p-2"> Sep </th>
                    <th class="p-2"> Oct </th>
                    <th class="p-2"> Nov </th>
                    <th class="p-2"> Dec </th>
                    <th class="p-2"> Jan </th>
                    <th class="p-2"> Feb </th>
                    <th class="p-2"> Mar </th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="p-2 bg-secondary text-black">
                            <label for="" class="">Basic</label>
                        </td>
                        <td class="p-2">
                            <label>118200</label>
                        </td>
                        @for ($j = 0; $j < 12; $j++)
                        <td class="p-2">
                            <label>118200</label>
                        </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="col-sm-12 mt-3">
        <div class="d-flex justify-content-between">
            <div>
                <label for="" class="text-muted"> Total Annual Salary : </label>
                Rs. 3,02,256
            </div>
        </div>
    </div>
</div>