<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
    
    <thead>
        <tr class="fw-bolder text-muted">
            <th class="min-w-50px">Subjects</th>
            @isset($classes)
                @foreach ($classes as $item)
                    <th class="min-w-120px" id="{{ $item->id }}">{{ $item->name }}</th>
                @endforeach
            @endisset
            <th class="min-w-120px">NO</th>
        </tr>
    </thead>
 
    <tbody>
        @isset($subjects)
            @foreach ($subjects as $items)
            <tr>
                <td class="text-dark fw-bolder text-hover-primary fs-6">
                    {{ $items->name }}
                </td>
                @isset($classes)
                    @foreach ($classes as $item)
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input widget-13-check" name="studied[]" id="subject_class" type="checkbox" value="{{ $items->id }}_{{ $item->id }}" />
                        </div>
                    </td>
                    @endforeach
                @endisset
                <td>
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input widget-13-check" type="checkbox" name="no_studied[]" value="{{ $items->id }}" />
                    </div>
                </td>
            </tr>
            @endforeach
        @endisset
        
        
    </tbody>
    
</table>
