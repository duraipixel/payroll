@extends('layouts.template')
@section('content')
    <section style="min-height: 93vh" class="p-3">
        <div class="card shadow border border-secondary rounded">
            <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">
                <div>
                    <select name="limit" onchange="setTableLimit(this)" class="border shadow-sm">
                        @for ($i = 0; $i < 4; $i++)
                            @php
                                $limit = ($i + 1) * 10
                            @endphp
                            <option {{ request()->limit == $limit ? 'selected' : ''  }} value="{{ $limit }}">{{ $limit }}</option>
                        @endfor
                        <option  {{ request()->limit === 'all' ? 'selected' : ''  }} value="all">All</option>
                    </select>
                    <b>Staff History Report</b>
                </div>
                <div class="d-flex">
                    <form action="{{ route('reports.staff.history') }}" class="input-group w-auto d-inline" method="GET">
                        <button onclick="this.form.action = '{{ route('reports.staff.export') }}'" type="submit" class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                        <input type="text" name="name" value="{{ request()->name }}" class="form-control form-control-sm  w-auto d-inline" placeholder="Search Staff Name.." />
                        <select name="department" class="form-select form-select-sm w-auto d-inline">
                            <option value="">-- Department --</option>
                            @foreach (Department() as $department)
                                <option {{ request()->department == $department->id ? 'selected' : '' }} value="{{ $department->id }}"> {{ $department->name }}</option>
                            @endforeach
                        </select>
                        <button onclick="this.form.action = '{{ route('reports.staff.history') }}';" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Find</button>
                        <a href="{{ route('reports.staff.history') }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-repeat"></i> 
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    @include('pages.reports.staff.history._table')
                </div>
            </div>
            <div class="card-footer p-2 bg-light">
                {!! $users->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
