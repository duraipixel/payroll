<?php

namespace App;

use App\Models\User;

trait ReportHelper
{
    function collection($request)
    {
        return User::where('institute_id',session()->get('staff_institute_id'))->with(['salary' => function ($q) use ($request) {
            if (!empty($request->month)) {
                $q->where('salary_month', date('F', mktime(0, 0, 0, $request->month, 1)));
            }
        }])->when(!empty($request->name), function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->name . '%');
        })->whereHas('position.department', function ($q) use ($request) {
            if (!empty($request->department)) $q->where('id', '=', $request->department);
        })->when(in_array(request()->route()->getName(),['reports.retirement','reports.retirement.export']), function ($q) use ($request) {
            $q->whereIn('users.id', function ($query) {
                $query->select('staff_id')
                        ->from('staff_retired_resigned_details')
                        ->where('types','retired')
                        ->groupBy('staff_id')
                        ->havingRaw('COUNT(*) = 1');
            });
        })->select('*');
    }
}
