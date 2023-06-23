<div class="bg-primary p-2 d-flex align-items-center justify-content-between py-2">
    <h3 class="fs-7 text-white m-0">
        <span class="card-label fw-bolder fs-5 mb-1">Staff Studied Subjects</span>
    </h3>
</div>

<div class="card-body py-3" id="studied_subject_table" style="height: 400px;overflow:auto">

    <table id="studied_table" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">

        <thead>
            <tr class="fw-bolder text-muted">
                <th class="min-w-50px">Subjects</th>
                @if(config('constant.staff_studied_classes'))
                    @foreach (config('constant.staff_studied_classes') as $item)
                        <th class="min-w-30px text-center" id="{{ $item }}">
                            {{ $item }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>

        <tbody>
            @if(config('constant.staff_studied_subjects'))
            @foreach (config('constant.staff_studied_subjects') as $items)
                    <tr>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            {{ str_replace('_', ' ',$items) }}
                        </td>
                        @if(config('constant.staff_studied_classes'))
                            @foreach (config('constant.staff_studied_classes') as $item)
                                <td class="text-center m-w-30px">
                                    <div
                                        class="form-check justify-content-center form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input widget-13-check" style="border: 1px solid #797474;"
                                            name="studied_{{$items}}" id="subject_class" type="radio"
                                            value="{{ $items }}_{{ $item }}"
                                            @if (isset($staff_details->id) && getStudiedSubjects($staff_details->id, $items, $item)) checked @endif 
                                            />
                                    </div>
                                </td>
                            @endforeach
                        @endif
                    </tr>
                @endforeach
            @endisset

        </tbody>

    </table>

    <!--end::Table container-->
</div>
