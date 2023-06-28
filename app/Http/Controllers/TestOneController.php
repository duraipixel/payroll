<?php

namespace App\Http\Controllers;

use App\Imports\OldStaffEntryImport;
use App\Models\Master\AppointmentOrderModel;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class TestOneController extends Controller
{

    public function testAppointmentPdf()
    {
        $info = AppointmentOrderModel::find(5);

        $params = array(
            'appointment_order_no' => 'ORder/121/1221',
            'appointment_date' => '2023-02-12',
            'staff_name' => 'Mrs. Durairaj.S',
            'designation' => 'Teacher',
            'institution_name' => 'Amalorpavam',
            'place' => 'Puducherry',
            'salary' => '25000'
        );

        $data = $info->document;
        
        foreach ($params as $key => $value) {
            $data = str_replace('$'.$key, $value, $data);
        }
        

        $pdf = PDF::loadView('pages.masters.appointment_order_model.dynamic_pdf', [ 'data' => $data])->setPaper('a4', 'portrait');
        return $pdf->stream('appointment.pdf');
    }

    public function deletePreviewPdf(Request $request)
    {
        $path = 'public/order_preview';
        if (File::exists($path)) {            
            File::deleteDirectory($path);
        }
    }

    public function importOldEntry()
    {
        Excel::import( new OldStaffEntryImport, request()->file('file') );
        return response()->json(['error'=> 0, 'message' => 'Imported successfully']);
    }

    public function sampleITStatement() {
        $data = [];
        $pdf = PDF::loadView('pages.sample.pdf.income_tax_statement', [ 'data' => $data])->setPaper('a4', 'portrait');
        return $pdf->stream('appointment.pdf');
    }
}
