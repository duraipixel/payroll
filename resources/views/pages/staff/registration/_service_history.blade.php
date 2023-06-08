<style>
.tableFixHead          { overflow: auto; height: 300px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
</style>
<div class="table-responsive tableFixHead mt-5" style="box-shadow: 1px 2px 3px 4px #98aac173;">
    <h3 class="p-3 text-center"> Service History</h3>
    <table class="table table-hover table-row-dashed align-middle gs-0 gy-3 my-0 ">
        <thead>
            <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                <th class="p-0 p-3 min-w-50px bg-dark">No</th>
                <th class="p-0 p-3 bg-dark">From</th>
                <th class="p-0 p-3 bg-dark">To</th>
                <th class="p-0 p-3 bg-dark pe-12">Appointment</th>
                <th class="p-0 p-3 bg-dark pe-7">Category</th>
                <th class="p-0 p-3 bg-dark">View</th>
            </tr>
        </thead>

        <tbody>
            @for ($i = 0; $i < 20; $i++)
                <tr>
                    <td class="p-3"> 1 </td>
                    <td  class="p-3">tste</td>
                    <td  class="p-3"> sd</td>
                    <td  class="p-3"> sd</td>
                    <td  class="p-3"> dfds</td>
                    <td  class="p-3"> </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
