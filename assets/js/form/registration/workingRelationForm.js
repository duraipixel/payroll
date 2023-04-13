function openRelationWorkingForm() {
        
    $('#kt_new_aews_toggle').click();

    $('#working_relation_id').val('');
    $('#working_relationship_type_id').val('');
    $('#working_emp_code').val('');
    $('#working_institute_id').val('');
    $('#relation_working_id').val('');
    event.preventDefault();

}

function editRelationWorkingForm(staff_id, working_id) {
    $('#kt_new_aews_toggle').click();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: relationWorkingFormContentUrl,
        type: "POST",
        data: {
            working_id: working_id
        },
        success: function(res) {
            $('#relation_working_form').html(res);
            $('#working_relation_title').html('Update Your Relation Working');
        }
    })

    event.preventDefault();
}

function submitRelationWorkingDetails() {
    var workingErrors = false;
    var key_name = [
        'working_relation_id',
        'working_relationship_type_id',
        'working_emp_code',
        'working_institute_id',
    ];
    $('.working-form-errors').remove();
    $('.form-control,.form-select').removeClass('border-danger');

    key_name.forEach(element => {
        var name_input = document.getElementById(element).value;

        if (name_input == '' || name_input == undefined) {
            workingErrors = true;
            var name_input_error =
                '<div class="fv-plugins-message-container working-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
            // $('#' + element).after(name_input_error);
            $('#' + element).addClass('border-danger')
            $('#' + element).focus();
        }
    });

    if (!workingErrors) {
        var staff_id = $('#outer_staff_id').val();
        var forms = $('#relation_working_form')[0];
        var formData = new FormData(forms);
        formData.append('staff_id', staff_id);
        $.ajax({
            url: insertRelationWorkingDetailUrl,
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
                        "Staff Working Relation added successfully"
                    );
                    $('#kt_help_close').click();
                    getStaffWorkingRelationList(staff_id);
                }
            }
        })
    }
}

function getStaffWorkingRelationList(staff_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: StaffRelationWorkingListUrl,
        type: "POST",
        data: {
            staff_id: staff_id
        },
        success: function(res) {
            $('#working-relation-list-pane').html(res);
        }
    })
}

function deleteRelationWorking(staff_id, working_id) {
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
                url: deleteStaffRelationWorkingUrl,
                type: "POST",
                data: {
                    working_id: working_id
                },
                success: function(res) {

                    getStaffWorkingRelationList(staff_id);

                    Swal.fire(
                        'Deleted!',
                        'Your Working Relation data has been deleted.',
                        'success'
                    )
                }
            })

        }
    })
}