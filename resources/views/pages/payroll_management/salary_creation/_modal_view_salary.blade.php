<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header">
            <!--begin::Modal title-->
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <!--end::Modal title-->
            <!--begin::Close-->
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-lg-10 px-lg-10 py-4">
            <div class="row">
                <div class="col-sm-12 py-2 text-end">
                    {{-- <a href="{{ route('salary.preview.pdf', ['staff_id' => $staff_info->id]) }}" target="_blank" class="btn btn-sm btn-light-success" >
                        <i class="fa fa-download"></i> PDF
                    </a> --}}
                    <a href="javascript:void(0)" onclick="return printDiv('salary_print_area')"
                        class="btn btn-sm btn-light-success">
                        <i class="fa fa-print"></i> Print
                    </a>
                </div>
            </div>
            <div id="salary_print_area">

                @include('pages.payroll_management.salary_creation._salary_slip')
            </div>
            <div class="row">
                <div class="col-sm-12 text-end">
                    <button class="btn btn-dark" type="button"  onclick="closeModal()"> Close
                    </button>
                </div>
            </div>
        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<script>
    function printDiv(divName) {

        var toPrint;
        toPrint=window.open();
        toPrint.document.write(document.getElementById(divName).innerHTML);
        toPrint.print();
        toPrint.close();
        
    }

    function closeModal() {
        console.log('clidkced');
        $('#kt_dynamic_app').modal('hide');
    }
</script>
