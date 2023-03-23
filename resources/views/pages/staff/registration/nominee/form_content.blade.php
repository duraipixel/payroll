@csrf
<div class="row">

    <div class="col-lg-12 mb-5">

        <label class="form-label required">Nominee Name</label>
        <select name="nominee_id" id="nominee_id" class="form-control" onchange="getNomineeDetails(this.value)">
            <option value="">--Select--</option>
        </select>

    </div>

    <div class="col-lg-12 mb-5">

        <div class="form-group">
            <table class="table table-hover table-bordered w-75" id="nominee-info-pane">

            </table>
        </div>

    </div>
    <input type="hidden" name="staff_nominee_id" id="staff_nominee_id" value="{{ $nominee_info->id ?? '' }}">
    <div class="col-lg-6 mb-5">
        <label class="form-label required">Age</label>
        <input name="nominee_age" value="{{ $nominee_info->age ?? '' }}" id="nominee_age" class="form-control form-control-lg form-control-solid"
            maxlength="2" />
    </div>



    <div class="col-lg-6 mb-5">

        <label class="form-label">Share %</label>

        <input name="share" id="share" value="{{ $nominee_info->share ?? '' }}" maxlength="3" class="form-control number_only form-control-lg form-control-solid" />

    </div>

    <div class="col-lg-6 mb-5 nominee-pane" @if( isset($nominee_info->minor_name) && !empty($nominee_info->minor_name)) @else style="display: none" @endif >
        <label class="form-label">Name If Nominee is Minor
        </label>
        <input name="minor_name" value="{{ $nominee_info->minor_name ?? '' }}" id="minor_name" class="form-control form-control-lg form-control-solid" />
    </div>

    <div class="col-lg-6 mb-5 nominee-pane"  @if( isset($nominee_info->minor_name) && !empty($nominee_info->minor_name)) @else style="display: none" @endif>
        <label class="form-label">Contact Number If
            Nominee is Minor
        </label>
        <input name="minor_contact" value="{{ $nominee_info->minor_contact_no ?? '' }}" maxlength="10" id="minor_contact" class="form-control number_only form-control-lg form-control-solid" />
    </div>


    <div class="col-lg-12 mb-5 nominee-pane"  @if( isset($nominee_info->minor_name) && !empty($nominee_info->minor_name)) @else style="display: none" @endif>
        <!--end::Label-->
        <label class="form-label">Address If
            Nominee is Minor </label>

        <textarea name="minor_address" id="minor_address" class="form-control form-control-lg form-control-solid" rows="3">{{ $nominee_info->minor_address ?? '' }}</textarea>

    </div>
    <!--end::Input group-->
    <div class="d-flex flex-stack pt-5">
        <!--begin::Wrapper-->
        <div>
            <button type="button" onclick="return addNominee()"  class="btn btn-lg btn-primary me-3 d-inline-block">
                <span class="indicator-label"> Submit
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                rx="1" transform="rotate(-180 18 13)" fill="currentColor"></rect>
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                
            </button>
        </div>
    </div>
</div>
<script>

    var edit_nominee_id = '{{ $nominee_info->nominee_id ?? '' }}';
</script>

<script>
    
    function getNominee() {

        var staff_id = $('#outer_staff_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.nominee.get') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                
                var optionElem = '<option value=""> Select </option>';
                res.map((item) => {
                    optionElem += `<option value="${item.id}" ${item.id == edit_nominee_id ? 'selected' : ''}>${item.first_name}</option>`;
                })

                $('#nominee_id').html(optionElem);

                if( edit_nominee_id ) {
                    getNomineeDetails(edit_nominee_id)
                }
            }
        })
    }

    getNominee();

    function getNomineeDetails(nominee_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.nominee.info') }}",
            type: "POST",
            data: {
                nominee_id: nominee_id
            },
            beforeSend: function() {
                $('#nominee-info-pane').html('');
            },
            success: function(res) {
                
                var tableContent = `<tr>
                    <th class="p-3"> 
                        <b>
                            Relationship Type
                        </b>
                        </th>
                    <td class="text-start"> ${res.relationship.name} </td>
                </tr>
                <tr>
                    <th class="p-3"> 
                        <b>
                            Date Of Birth
                        </b>
                        </th>
                    <td class="text-start"> ${res.dob} </td>
                </tr>
                <tr>
                    <th class="p-3"> 
                        <b>
                            Gender
                        </b>
                        </th>
                    <td class="text-start"> ${res.gender.toUpperCase()} </td>
                </tr>`;
                $('#nominee-info-pane').html(tableContent);
            }
        })
    }

    $("#nominee_age").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    $('#nominee_age').keyup(function(e){

        if( e.target.value < 18 ) {
            $('.nominee-pane').show();
        } else {
            $('.nominee-pane').hide();
        }
    })
</script>
