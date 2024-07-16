@extends('layouts.template')
@section('content')
    <section style="min-height: 93vh" class="p-3">
        <div class="card shadow border border-secondary rounded">
        <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">   <b  >Attendance Report</b>
       </div>
        <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">
                <div>
                    <select name="limit" onchange="setTableLimit(this)" class="border shadow-sm">
                        @for ($i = 0; $i < 10; $i++)
                            @php
                                $limit = ($i + 1) * 10;
                            @endphp
                            <option {{ request()->limit == $limit ? 'selected' : '' }} value="{{ $limit }}">
                                {{ $limit }}</option>
                        @endfor
                        <option {{ request()->limit === 'all' ? 'selected' : '' }} value="all">All</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <form action="{{ route('reports.attendance') }}" class="input-group w-auto d-inline" method="GET">
                     
                    <input type="text" name="search" placeholder="Search User"  value="{{ request()->input('search') }}" class="form-control w-auto d-inline" style="height: 34.33px;">

                        <select name="division_id" id="division_id" class="form-select form-select-sm w-auto d-inline" >
                            <option value="">--Select Division--</option>
                            @isset($divisions)
                                @foreach ($divisions as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $division_id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                     <select name="department_id"  class="form-select form-select-sm w-auto d-inline" id="department_id"
                           >
                            <option value="">--Select Department--</option>
                            @isset($department)
                                @foreach ($department as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $department_id ? 'selected' : '' }} >
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <select name="place_of_work" class="form-select form-select-sm w-auto d-inline">
                            <option value="">-- Place of work --</option>
                            @foreach (placeOfWork() as $place)
                                <option value="{{ $place->id }}" {{ $place->id == $place_of_work ? 'selected' : '' }}>
                                    {{ $place->name }}</option>
                            @endforeach
                        </select>
                        
                        <select name="month" class="form-select form-select-sm w-auto d-inline mt-3">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                        <div class="bg-light border-bottom m-2" style="text-align: right;">
                        <button onclick="this.form.action = '{{ route('reports.attendance.export') }}'" type="submit"
                        class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                        <button onclick="this.form.action = '{{ route('reports.attendance') }}';" type="submit"
                            class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Find</button>
                        <a href="{{ route('reports.attendance') }}" class="btn btn-sm btn-warning"><i
                                class="fa fa-repeat"></i></a>
                           </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    @include('pages.reports.attendance._table')
                </div>
            </div>
            <div class="card-footer p-2 bg-light">
                {!! $attendance->appends($parameters)->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
