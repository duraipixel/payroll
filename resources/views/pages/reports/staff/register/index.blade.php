@extends('layouts.template')
@section('content')
    <section style="min-height: 93vh" class="p-3">
        <div class="card shadow border border-secondary rounded">
            <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">
                <b>Salary History Report</b>
                <div class="d-flex">
                    <form action="{{ route('reports.salary.register') }}" class="input-group w-auto d-inline" method="GET">
                        <button onclick="this.form.action = '{{ route('reports.salary.export') }}'" type="submit" class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                        <input type="text" name="name" value="{{ request()->name }}" class="form-control form-control-sm  w-auto d-inline" placeholder="Search Staff Name.." />
                        <select name="department" class="form-select form-select-sm w-auto d-inline">
                            <option value="">-- Department --</option>
                            @foreach (Department() as $department)
                                <option {{ request()->department == $department->id ? 'selected' : '' }} value="{{ $department->id }}"> {{ $department->name }}</option>
                            @endforeach
                        </select>
                        <button onclick="this.form.action = '{{ route('reports.salary.register') }}';" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Find</button>
                        <a href="{{ route('reports.salary.register') }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-repeat"></i> 
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    @include('pages.reports.staff.register._table')
                </div>
            </div>
            <div class="card-footer p-2 bg-light">
                {!! $users->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
