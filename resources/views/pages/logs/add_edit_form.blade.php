<form action="" class="" id="dynamic_form">
    <table class="table align-middle table-row-dashed gy-5" id="kt_table_customers_payment">
      
        <tbody class="fs-6 fw-bold text-gray-600">
            <tr>
                <td>
                    <label for=""><strong>User Name</strong> </label>
                </td>
                <td>
                    <label for="">{{ $info->user->name ?? ''}}</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""><strong>User Email</strong> </label>
                </td>
                <td>
                    <label for="">{{ $info->user->email ?? '' }}</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""><strong>Event</strong> </label>
                </td>
                <td>
                    <label for="">{{ $info->event ?? '' }}</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""><strong>Auditable Type</strong> </label>
                </td>
                <td>
                    <?php $data = (explode('\\',$info->auditable_type));
                    print_r(end($data));
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""><strong>Old Value</strong> </label>
                </td>
                <td>
                   <?php $oldData = json_decode($info->old_values) ?>
                   <table class="table align-middle table-row-dashed gy-5" id="kt_table_customers_payment">
                        <tbody class="fs-6 fw-bold text-gray-600">
                            @foreach ($oldData as $key=>$val)
                            <tr>
                                <td>{{ $key }} :</td><td>{{ $val }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <label for=""><strong>New Value</strong> </label>
                </td>
                <td>
                    <?php $newData = json_decode($info->new_values) ?>
                    <table class="table align-middle table-row-dashed gy-5" id="kt_table_customers_payment">
                         <tbody class="fs-6 fw-bold text-gray-600">
                             @foreach ($newData as $key=>$val)
                             <tr>
                                <td>{{ $key }} :</td><td>{{ $val }}</td>
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                </td>
            </tr>
           
            <tr>
                    <td>
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
                    </td>
            </tr>
        </tbody>
</form>

