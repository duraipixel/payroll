<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
    
    <thead>
        <tr class="fw-bolder text-muted bg-dark text-white">
            <th class="min-w-50px p-2">Subjects</th>
            @if( isset($class_details) && count($class_details) > 0 )
                @foreach ($class_details as $item)
                    <th class="min-w-120px" id="{{ $item->id }}">{{ $item->name }}</th>
                @endforeach
            @endif
        </tr>
    </thead>
 
    <tbody class="bg-white">
        @if( isset($subject_details) && count($subject_details) > 0 )
            @foreach ($subject_details as $items)
            <tr>
                <td class="text-dark p-2 fw-bolder text-hover-primary fs-6">
                    {{ $items->name }}
                </td>
                @if( isset($class_details) && count($class_details) > 0 )
                    @foreach ($class_details as $item)
                    <td class="p-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input style="border: 1px solid #797474;" class="form-check-input widget-13-check" name="handled[]" id="subject_class" type="checkbox" value="{{ $items->id }}_{{ $item->id }}" @if( isset($staff_details->id) && getHandlingSubjects( $staff_details->id, $items->id, $item->id )) checked @endif/>
                        </div>
                    </td>
                    @endforeach
                @endif
            </tr>
            @endforeach
        @endif
    </tbody>
    
</table>
