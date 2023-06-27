@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .it-table td,
        th {
            border: 1px solid black
        }
    </style>
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3> {{ $title ?? '' }}</h3>
            </div>
            <div class="card-toolbar">
                <div class="form-group ">
                    <button class="btn btn-sm btn-primary" type="button" onclick="addNewTaxSlab()"> Add New Tax Scheme
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="card">
                <table class="it-table">
                    <thead class="bg-primary text-white p-3">
                        <tr>
                            <th class="p-3">
                                Tax Slab
                            </th>
                            @if (isset($scheme) && count($scheme) > 0)
                                @foreach ($scheme as $item)
                                    <th class="p-3 text-center">
                                        <div class="d-flex">
                                            <div class="w-50">
                                                {{ $item->scheme }}
                                                <div class="text-center">
                                                    <label
                                                        class="badge @if (getItSlabInfo($item->slug)->status == 'active') badge-light-success @else badge-light-danger @endif">
                                                        {{ getItSlabInfo($item->slug)->status }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="w-50">
                                                <button class="btn btn-sm btn-info ms-1"
                                                    onclick="return addNewTaxSlab('{{ $item->slug }}')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-warning ms-1" tooltip="Click to change Status"
                                                    onclick="return changeSlabStatus('{{ $item->slug }}')">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($slab) && count($slab) > 0)
                            @foreach ($slab as $sitem)
                                <tr>
                                    <td class="p-3">
                                        {{ $sitem->from_amount == '0.00' ? 'Up to ' : 'Rs .' . $sitem->from_amount }}
                                        Rs. {{ $sitem->to_amount }}
                                    </td>
                                    @if (isset($scheme) && count($scheme) > 0)
                                        @foreach ($scheme as $item)
                                            <td class="p-3 text-center">
                                                {{-- {{ getITSlabeInfo($sitem->from_amount, $sitem->to_amount, $item->slug)->percentage ? (int) getITSlabeInfo($sitem->from_amount, $sitem->to_amount, $item->slug)->percentage : 0 }}% --}}
                                                {{ getITSlabeInfo($sitem->from_amount, $sitem->to_amount, $item->slug) ? (int) getITSlabeInfo($sitem->from_amount, $sitem->to_amount, $item->slug)->percentage : 0 }}%
                                            </td>
                                        @endforeach
                                    @endif


                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        function addNewTaxSlab(slug) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('it.tabulation.modal') }}",
                type: 'POST',
                data: {
                    slug: slug
                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })
        }

        function changeSlabStatus(slug) {

            Swal.fire({
                text: "Are you sure you would like to change status?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Change it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('it.tabulation.status.change') }}",
                        type: 'POST',
                        data: {
                            slug:slug
                        },
                        success: function(res) {
                            if( res ) {

                                Swal.fire({
                                    title: "Updated!",
                                    text: res.message,
                                    icon: "success",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    },
                                    timer: 3000
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }

                        },
                        error: function(xhr, err) {
                            if (xhr.status == 403) {
                                toastr.error(xhr.statusText, 'UnAuthorized Access');
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
