@extends('layouts.template')
@section('content')
    <section style="min-height: 93vh" class="p-3">
        <div class="card shadow border border-secondary rounded">
            <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">
                <div>
                    <select name="limit" onchange="setTableLimit(this)" class="border shadow-sm">
                        @for ($i = 0; $i < 10; $i++)
                            @php
                                $limit = ($i + 1) * 10
                            @endphp
                            <option {{ request()->limit == $limit ? 'selected' : ''  }} value="{{ $limit }}">{{ $limit }}</option>
                        @endfor
                        <option  {{ request()->limit === 'all' ? 'selected' : ''  }} value="all">All</option>
                    </select>
                    <b>Leave Report</b>
                </div>
                <div class="d-flex">
                    <form action="{{ route('reports.leaves') }}" class="input-group w-auto d-inline" method="GET">
                        <button onclick="this.form.action = '{{ route('reports.leaves.export') }}'" type="submit"
                            class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                        <input type="text" name="name" value="{{ request()->name }}"
                            class="form-control form-control-sm  w-auto d-inline" placeholder="Search Staff Name.." />
                        <button onclick="this.form.action = '{{ route('reports.leaves') }}';" type="submit"
                            class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Find</button>
                        <a href="{{ route('reports.leaves') }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-repeat"></i>
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    @include('pages.reports.leaves._table')
                </div>
            </div>
            <div class="card-footer p-2 bg-light">
                {!! $leaves->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
