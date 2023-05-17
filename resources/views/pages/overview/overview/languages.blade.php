@isset($info->knownLanguages)

    <div class="card card-flush h-xl-100 cstmzed">
        <div class="card-header pt-10">
            <h1 class="text-dark mb-5 fw-bolder">Languages Known</h1>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fs-5 fw-bold border-0 text-gray-400">
                            <th class="">Languages</th>
                            <th class="text-center">Is Read</th>
                            <th class="text-center">Is Write</th>
                            <th class="text-center">Is Speak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($info->knownLanguages as $item)
                            <tr>
                                <td class="">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $item->language->name }}</a>
                                </td>
                                <td class="pe-0">
                                    <div class="d-flex justify-content-center">
                                        @if( $item->read )
                                        {!! yesTickSvg() !!}
                                        @else
                                        {!! noTickSvg() !!}
                                        @endif
                                    </div>
                                </td>
                                <td class="pe-0">
                                    <div class="d-flex justify-content-center">
                                        @if( $item->write )
                                        {!! yesTickSvg() !!}
                                        @else
                                        {!! noTickSvg() !!}
                                        @endif
                                    </div>
                                </td>
                                <td class="pe-0">
                                    <div class="d-flex justify-content-center">
                                        @if( $item->speak )
                                        {!! yesTickSvg() !!}
                                        @else
                                        {!! noTickSvg() !!}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endisset