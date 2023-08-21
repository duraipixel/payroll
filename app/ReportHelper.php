<?php

namespace App;

use App\Models\User;

trait ReportHelper
{
    function collection($request)
    {
        return User::with(['salary' => function ($q) use ($request) {
            if (!empty($request->month)) { 
                $q->where('salary_month', date('F', mktime(0, 0, 0, $request->month , 1)));
            }
        }])->when(!empty($request->name), function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->name . '%');
        })->whereHas('position.department', function ($q) use ($request) {
            if (!empty($request->department)) $q->where('id', '=', $request->department);
        })->select('*');
    }
}
