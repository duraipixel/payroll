@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .sticky-col {
            position: -webkit-sticky;
            position: sticky;
            background-color: white !important;
        }

        .first-col {
            width: 35px;
            min-width: 35px;
            max-width: 35px;
            left: 0px;
        }

        .second-col {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
            left: 35px;
        }

        .third-col {
            width: 200px;
            min-width: 200px;
            max-width: 200px;
            left: 150px;
        }
    </style>
        <div class="card position-relative">
        <div class="card-header mt-10 text-center">
        <h3> Payroll Processing for Month {{ date('d/M/Y', strtotime($info->from_date)) }} </h3>
        </div>
        <div class="card-body py-4" id="dynamic_content_test">
        <div class="row">
        <div class="col-sm-12">
        <table class="table table-striped">
        <tr>
            <td> Employee </td>
            <td> {{ $info->salaryStaff->count() }} </td>
        </tr>
        <tr>
            <td> Gross Pay </td>
            <td> {{ $info->salaryStaff->sum('gross_salary') }}</td>
        </tr>
        <tr>
            <td> Deduction </td>
            <td> {{ $info->salaryStaff->sum('total_deductions') }} </td>
        </tr>
        <tr>
            <td> Net Pay </td>
            <td> {{ $info->salaryStaff->sum('net_salary') }} </td>
        </tr>

        </table>

        </div>
        <div class="col-sm-12 text-start">
        <a href="{{ route('payroll.statement', ['id' => $info->id]) }}" class="btn btn-primary"> 
        View Salary Statement
        </a>
        <a href="{{ route('payroll.overview') }}" class="btn btn-dark">
        Close
        </a>
        </div>
        </div>
        </div>
        </div>
 @endsection
@section('add_on_script')
@endsection
