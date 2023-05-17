<div data-kt-stepper-element="content">
    <div class="w-100">
        <div class="card card-flush py-0">
            <div class="pt-0">
                <div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">
                    <div class="pb-5 pb-lg-5">
                        <h2 class="fw-bolder text-dark">Medical Details</h2>
                    </div>
                    <form id="medicalForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 mb-5">
                                <label class="form-label required">Blood Group</label>
                                <div class="position-relative">
                                    <select name="medical_blood_group_id" autofocus id="medical_blood_group_id"
                                        class="form-select form-select-lg select2-option" required>
                                        <option value="">--Select Type --</option>
                                        @isset($blood_groups)
                                            @foreach ($blood_groups as $item)
                                                <option value="{{ $item->id }}" @if (isset($staff_details->healthDetails->bloodgroup_id) && $staff_details->healthDetails->bloodgroup_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if( access()->buttonAccess('blood_group','add_edit') )
                                    <span class="position-absolute btn btn-success btn-md top-0 end-0" onclick="return openAddModel('medic_blood_group')">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label class="form-label required">Height in Cms</label>
                                <input name="height" id="height" value="{{ $staff_details->healthDetails->height ?? ''  }}" class="price form-control form-control-lg " />
                            </div>
                            <div class="col-lg-4 mb-5">
                                <label class="form-label required">Weight in Kgs</label>
                                <input name="weight" id="weight" value="{{ $staff_details->healthDetails->weight ?? ''  }}" class="price form-control form-control-lg " />
                            </div>
                            
                            <div class="col-lg-4 mb-5">
                                <label class="form-label required">Identification mark</label>
                                <input name="identification_mark" id="identification_mark" value="{{ $staff_details->healthDetails->identification_mark ?? ''  }}"
                                    class="form-control form-control-lg " />
                            </div>
    
                            <div class="col-lg-4 mb-5">
                                <label class="form-label">Identification mark 1</label>
                                <input name="identification_mark1" id="identification_mark1" value="{{ $staff_details->healthDetails->identification_mark1 ?? ''  }}"
                                    class="form-control form-control-lg " />
                            </div>
                            
                            <div class="col-lg-4 mb-5">
                                <label class="form-label">Identification mark 2</label>
                                <input name="identification_mark2" id="identification_mark2" value="{{ $staff_details->healthDetails->identification_mark2 ?? ''  }}"
                                    class="form-control form-control-lg " />
                            </div>
                            
                            <div class="col-lg-4 mb-5">
                                <label class="form-label">Family Doctor Name</label>
                                <input name="family_doctor_name" id="family_doctor_name" class="form-control form-control-lg " value="{{ $staff_details->healthDetails->family_doctor_name ?? ''  }}" />
                            </div>
                            
                            <div class="col-lg-4 mb-5">
                                <label class="form-label">Family Doctor Contact No</label>
                                <input name="doctor_contact_no" id="doctor_contact_no" class="form-control form-control-lg number_only" maxlength="10" value="{{ $staff_details->healthDetails->family_doctor_contact_no ?? ''  }}" />
                            </div>
                            <div class="row">

                                <div class="mb-5 col-lg-4 fv-row">
                                    <div class="DA_holder question">
                                        <div class="fw-bold me-5">
                                            <label class="fs-6">Disease Allergy</label>
                                        </div>
                                        <div
                                            class="DA_holder DA_radio_holder d-block mt-5 align-items-center cstm-zeed">
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-20px w-20px radio-btn"
                                                    type="radio" name="allergy" id="allergy_yes"
                                                    value="yes" @if( isset($staff_details->healthDetails->disease_allergy_name) && !empty( $staff_details->healthDetails->disease_allergy_name ) ) checked @endif />
                                                <span class="form-check-label fw-bold fl">Yes</span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-20px w-20px radio-btn"
                                                    type="radio" name="allergy" id="allergy_no"
                                                    value="no" @if( isset($staff_details->healthDetails->disease_allergy_name) && empty( $staff_details->healthDetails->disease_allergy_name ) ) checked @endif />
                                                <span class="form-check-label fw-bold f1">No</span>
                                            </label>
                                        </div>
                                    </div>
        
                                    <div class="DA_holder textField" @if( isset($staff_details->healthDetails->disease_allergy_name) && !empty( $staff_details->healthDetails->disease_allergy_name ) ) style="display:block" @endif>
                                        <div class="col-lg-12 mb-5">
                                            <label class="form-label"> </label>
                                            <input name="allergy_name" id="allergry_name" value="{{ $staff_details->healthDetails->disease_allergy_name ?? '' }}" class="form-control form-control-lg " 
                                            placeholder="Disease Allergy Name"/>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="mb-5 col-lg-4 fv-row">
                                    <div class="DA_holder question">
                                        <div class="fw-bold me-5">
                                            <label class="fs-6">Differently abled</label>
                                        </div>
                                        <div
                                            class="DA_holder DA_radio_holder d-block mt-5 align-items-center cstm-zeed">
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-20px w-20px radio-btn"
                                                    type="radio" name="diff_abled" id="diff_abled_yes" @if( isset($staff_details->healthDetails->differently_abled_name) && !empty( $staff_details->healthDetails->differently_abled_name ) ) checked @endif
                                                    value="yes" />
                                                <span class="form-check-label fw-bold fl">Yes</span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-20px w-20px radio-btn"
                                                    type="radio" name="diff_abled" id="diff_abled_no" @if( isset($staff_details->healthDetails->differently_abled_name) && empty( $staff_details->healthDetails->differently_abled_name ) ) checked @endif
                                                    value="no" />
                                                <span class="form-check-label fw-bold f1">No</span>
                                            </label>
                                        </div>
                                    </div>
        
                                    <div class="DA_holder textField" @if( isset($staff_details->healthDetails->differently_abled_name) && !empty( $staff_details->healthDetails->differently_abled_name ) ) style="display:block" @endif>
                                        <div class="col-lg-12 mb-5">
                                            <label class="form-label"> </label>
                                            <input name="abled_name" id="abled_name" value="{{ $staff_details->healthDetails->differently_abled_name ?? '' }}" placeholder="Differently abled name"
                                                class="form-control form-control-lg " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @include('pages.staff.registration.medical_remarks.remarks_pane')
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</div>

<script>

    function openMedicalRemarkForm() {
        $('#kt_new_family1_toggle').click();
        setTimeout(() => {
            $('#medic_remark_date').val('');
            $('#medic_file').val('');
            $('#medical_remark_id').val('');
            $('#remark_reason').val('');
            $('#medical_remarks_title').html('Add Your Medical Details');
            $('#medic_file_pane').hide();
        }, 100);
    }

    function editMedicRemarksForm( staff_id, remark_id ) {

        $('#kt_new_family1_toggle').click();
        $('#medic_file_pane').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('form.medic.remark.content') }}",
            type: "POST",
            data: {
                remark_id: remark_id
            },
            success: function(res) {

                $('#medical_remarks_form').html(res);
                $('#medical_remarks_title').html('Update Your Medical Details');
            }
        })
    }

    function deleteMedicRemark(staff_id, remark_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('delete.medic.remark') }}",
                    type: "POST",
                    data: {
                        remark_id: remark_id
                    },
                    success: function(res) {
                        staffMedicRemarksList(staff_id);
                        Swal.fire(
                            'Deleted!',
                            'Your Staff Medical Remarks data has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }

    function submitMedicalRemarks() {

        var remarksError = false;
        let key_name = [
            'medic_remark_date',
            'remark_reason'            
        ];
        $('.medical-remarks-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {

            var name_input = document.getElementById(element).value;
            if (name_input == '' || name_input == undefined) {
                remarksError = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container medical-remarks-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }

        });

        if (!remarksError) {

            var staff_id = $('#outer_staff_id').val();
            var forms = $('#medical_remarks_form')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);

            $.ajax({
                url: "{{ route('save.medical.remarks') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {

                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success(
                            "Medical Remarks added successfully"
                        );

                        $('#kt_help_close').click();
                        staffMedicRemarksList(staff_id);
                    }
                }
            })
        }
    }

    function staffMedicRemarksList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.medic.remarks.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#medical_remarks_list').html(res);
            }
        })
    }

    async function validateMedicalForm() {

        var medicErrors = false;
        let key_name = [
            'medical_blood_group_id',
            'height',
            'weight',
            'identification_mark'
        ];
        $('.medical-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                medicErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container medical-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if( !medicErrors ) {
            loading();
            var staff_id = $('#outer_staff_id').val();
            var forms = $('#medicalForm')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);

            const employeeResponse = await fetch("{{ route('staff.save.medical_information') }}", {
                    method: 'POST',
                    body: formData
                })
                .then((response) => response.json())
                .then((data) => {
                    unloading();
                    
                    if (data.error == 1) {
                        if (data.message) {
                            data.message.forEach(element => {
                                toastr.error("Error", element);
                            });
                        }                        
                        return true;
                    } else {
                        return false;
                    }

                });
            return employeeResponse;
        } else {
            return true;
        }

    }
</script>