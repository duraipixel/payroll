@if( isset( $user_info->transfer_status) && $user_info->transfer_status == 'active')
<div class="accordion" id="accordionPanelsStayOpenExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                aria-controls="panelsStayOpen-collapseOne">
                Add Bank Loans
            </button>
        </h2>
        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
            aria-labelledby="panelsStayOpen-headingOne">
            <div class="accordion-body" id="bank_loan_form_content">
                @include('pages.payroll_management.loan.form')
            </div>
        </div>
    </div>
</div>
@endif
<div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer mt-5">
    <div class="table-responsive">
        <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
            id="salary_loan_table">
            <thead class="bg-primary">
                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="text-center text-white">
                        Bank
                    </th>
                    <th class="text-center text-white">
                        IFSC
                    </th>
                    <th class="text-center text-white">
                        Ac no
                    </th>
                    <th class="text-center text-white">
                        Amount
                    </th>
                    <th class="text-center text-white">
                        Loan Type
                    </th>
                    <th class="text-center text-white">
                        Period of Loans
                    </th>
                    <th class="text-center text-white">
                        File
                    </th>
                    <th class="text-center text-white">
                        Status
                    </th>
                    @if( isset( $user_info->transfer_status) && $user_info->transfer_status == 'active')
                    <th class="text-center text-white">
                        Actions
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-bold">
                @isset($load_details)
                    @foreach ($load_details as $item)
                        <tr>
                            <td>{{ $item->bank_name }}</td>
                            <td>{{ $item->ifsc_code }}</td>
                            <td>{{ $item->loan_ac_no }}</td>
                            <td>{{ $item->loan_amount }}</td>
                            <td>{{ $item->loan_due }}</td>
                            <td>{{ $item->period_of_loans }}</td>
                            <td>
                                @if (isset($item->file) && !empty($item->file))
                                    {{-- <a href="{{ asset(Storage::url($item->file)) }}" class="" target="_blank"> Download File </a> --}}
                                    <a href="{{ asset('public' . Storage::url($item->file)) }}" class=""
                                        target="_blank"> View File </a>
                                @else
                                    <a href="javascript:void(0)"> No File Uploaded </a>
                                @endif
                            </td>
                            <td>{{ ucfirst($item->status) }}</td>
                            @if( isset( $user_info->transfer_status) && $user_info->transfer_status == 'active')
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="return editLoan('{{ $item->id }}')">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="return deleteLoan('{{ $item->id }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
<script>
    $(".number_only").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    $('#staff_id').select2({ theme: 'bootstrap-5'});

    $('#salary_loan_table').dataTable();

    function editLoan(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('edit.loan') }}",
            type: 'POST',
            data: {
                id: id,
            },
            success: function(res) {
                $('#bank_loan_form_content').html(res);
            }
        })
    }

    function deleteLoan(id) {

        Swal.fire({
            text: "Are you sure you would like to Delete Loan?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('delete.loan') }}",
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    success: function(res) {
                        if( res.staff_id ){
                            getSalaryBankLoans(res.staff_id);
                        }
                        Swal.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success",
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-success"
                            },
                            timer: 3000
                        });

                    },
                    error: function(xhr, err) {
                        if (xhr.status == 403) {
                            toastr.error(xhr.statusText, 'UnAuthorized Access');
                        }
                    }
                });
            }
        });
    }
</script>
