@extends('layouts.template')
@section('content')
    <section style="min-height: 93vh" class="p-3">
        <div class="card shadow border border-secondary rounded">
            <div class="bg-light border-bottom p-2 d-flex align-items-center justify-content-between">
                <b>Attendance Report</b>
                <div class="d-flex">
                    <form action="{{ route('reports.attendance') }}" class="input-group w-auto d-inline" method="GET">
                        <a href="{{ route('reports.attendance') }}" class="btn btn-sm btn-warning"><i
                                class="fa fa-repeat"></i> Reset</a>
                        <select name="place_of_work" class="form-select form-select-sm w-auto d-inline">
                            <option value="">-- Place of work --</option>
                            @foreach (placeOfWork() as $place)
                                <option value="{{ $place->id }}" {{ $place->id == $place_of_work ? 'selected' : '' }}>
                                    {{ $place->name }}</option>
                            @endforeach
                        </select>
                        <select name="month" class="form-select form-select-sm w-auto d-inline">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                        <button onclick="this.form.action = '{{ route('reports.attendance') }}';" type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                        <button onclick="this.form.action = '{{ route('reports.attendance.export') }}'" type="submit" class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                    </form>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    @include('pages.reports.attendance._table')
                </div>
            </div>
            <div class="card-footer p-2 bg-light">
                {!! $attendance->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
