function openNomineeForm() {
    event.preventDefault();
    $('#kt_new_nominiee_toggle').click();
    $('#nominee_id').val('');
    $('#nominee_age').val('');
    $('#share').val('');
    $('#minor_name').val('');
    $('#minor_contact').val('');
    $('#minor_address').val('');
    $('#staff_nominee_id').val('');

    getNominee();
    
}

function getFamilyNomiee() {

}

function editNomineeForm(staff_id, nominee_id) {
    event.preventDefault();
    $('#kt_new_nominiee_toggle').click();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: nomineeFormContentUrl,
        type: "POST",
        data: {
            nominee_id: nominee_id
        },
        success: function(res) {
            $('#nominee_form').html(res);
            $('#nominee_form_title').html('Update Your Nominee Details');
            getNominee();
        }
    })

}

function addNominee() {
    var nomineeErrors = false;
    let key_name = [
        'nominee_id',
        'nominee_age',
        'share'
    ];
    $('.nominee-form-errors').remove();
    $('.form-control,.form-select').removeClass('border-danger');

    key_name.forEach(element => {
        var name_input = document.getElementById(element).value;

        if (name_input == '' || name_input == undefined) {
            nomineeErrors = true;
            var name_input_error =
                '<div class="fv-plugins-message-container nominee-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
            // $('#' + element).after(name_input_error);
            $('#' + element).addClass('border-danger')
            $('#' + element).focus();
        }
    });

    if (!nomineeErrors) {
        var staff_id = $('#outer_staff_id').val();
        var forms = $('#nominee_form')[0];
        var formData = new FormData(forms);
        formData.append('staff_id', staff_id);
        $.ajax({
            url: insertNomineeUrl,
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
                        "Staff Nominee added successfully"
                    );
                    $('#kt_help_close').click();
                    getStaffNomineeList(staff_id);
                }
            }
        })
    }
}

function getStaffNomineeList(staff_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: staffNomineeList,
        type: "POST",
        data: {
            staff_id: staff_id
        },
        success: function(res) {
            $('#nominee-list-pane').html(res);
        }
    })
}

function deleteNominee(staff_id, nominee_id) {
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
                url: deleteStaffNomineeUrl,
                type: "POST",
                data: {
                    nominee_id: nominee_id
                },
                success: function(res) {

                    getStaffNomineeList(staff_id);

                    Swal.fire(
                        'Deleted!',
                        'Your Nominee data has been deleted.',
                        'success'
                    )
                }
            })

        }
    })
}