function openFamilyForm() {
    $('#kt_new_family_toggle').click();

    setTimeout(() => {
        $('#family-form-title').html('Add Your Family Details');
        $('#family_member_name').val('');
        $('#dob').val('');
        $('#gender').val('');
        $('#age').val('');
        $('#staff_relationship_id').val('').trigger('change');
        $('#qualification_id').val('').trigger('change');
        $('#premises').val('');
        $('#family_contact_no').val('');
        $('#blood_group_id').val('').trigger('change');
        $('#family_nationality').val('').trigger('change');
        $('#family_remarks').val('');
        $('#relation_register_no').val('');
        $('#relation_standard').val('');
        $('#family_residential_address').val('');
        $('#occupation_address').val('');
        $('#family_id').val('');

        getFamilyNationality();

    }, 100);

    event.preventDefault();
}

function getFamilyNationality(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: nationalityList,
        type: "POST",
        data: {
            id: 'family_nationality'
        },
        success: function(res) {

            if( res.list ) {
                var dp_text = '';

                res.list.map((item) => {
                    dp_text += `<option value="${item.id}">${item.name}</option>`;
                })
                
                $('#family_nationality').html(dp_text);

            }
        }
    })
}

function editFamilyForm(staff_id, family_id) {
    $('#kt_new_family_toggle').click();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: familyFormContentUrl,
        type: "POST",
        data: {
            family_id: family_id
        },
        success: function(res) {

            $('#family_form').html(res);
            $('#family-form-title').html('Update Your Family Details');
        }
    })
}

function deleteFamilyForm(staff_id, family_id) {
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
                url: deleteStaffFamilyDetailsUrl,
                type: "POST",
                data: {
                    family_id: family_id
                },
                success: function(res) {

                    staffFamilyMemberList(staff_id);

                    Swal.fire(
                        'Deleted!',
                        'Your Family member data has been deleted.',
                        'success'
                    )
                }
            })

        }
    })
}

function submitFamilyMemberForm() {
    var memberFormErrors = false;
    let key_name = [
        'staff_relationship_id',
        'family_member_name',
        'dob',
        'gender',
        'age',
        'qualification_id',
        'family_contact_no',
        'blood_group_id',
        'family_nationality'
    ];
    $('.family-form-errors').remove();
    $('.form-control,.form-select').removeClass('border-danger');

    key_name.forEach(element => {
        var name_input = document.getElementById(element).value;

        if (name_input == '' || name_input == undefined) {
            memberFormErrors = true;
            var name_input_error =
                '<div class="fv-plugins-message-container family-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
            // $('#' + element).after(name_input_error);
            $('#' + element).addClass('border-danger')
            $('#' + element).focus();
        }
    });

    if (!memberFormErrors) {
        var staff_id = $('#outer_staff_id').val();
        var forms = $('#family_form')[0];
        var formData = new FormData(forms);
        formData.append('staff_id', staff_id);
        $.ajax({
            url: insertFamilyMemberUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                // Disable submit button whilst loading
                if (res.error == 1) {
                    if (res.message) {
                        res.message.forEach(element => {
                            toastr.error("Error",
                                element);
                        });
                    }
                } else {
                    toastr.success(
                        "Family Member Details added successfully"
                    );
                    $('#kt_help_close').click();
                    staffFamilyMemberList(staff_id);
                }
            }
        })
    }
}


function staffFamilyMemberList(staff_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: staffMemberList,
        type: "POST",
        data: {
            staff_id: staff_id
        },
        success: function(res) {
            $('#family-list-pane').html(res);
        }
    })
}