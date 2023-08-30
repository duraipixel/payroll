@extends('layouts.template')
@section('content')
    <section style="min-height: 93vh" class="p-3">
        <div class="card shadow border border-secondary rounded">
            <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">
                <b>Staff History Report</b>
                <div class="d-flex">
                    <form action="{{ route('reports.retirement') }}" class="input-group w-auto d-inline" method="GET">
                        <button onclick="this.form.action = '{{ route('reports.retirement.export') }}'" type="submit" class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                        <input type="text" name="name" value="{{ request()->name }}" class="form-control form-control-sm  w-auto d-inline" placeholder="Search Staff Name.." />
                        <button onclick="this.form.action = '{{ route('reports.retirement') }}';" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Find</button>
                        <a href="{{ route('reports.retirement') }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-repeat"></i> 
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    @include('pages.reports.retirement._table')
                </div>
            </div>
            <div class="card-footer p-2 bg-light">
                {!! $users->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
