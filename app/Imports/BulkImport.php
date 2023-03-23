<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Master\Institution;
use App\Models\Master\Division;
use App\Models\Staff\StaffDocument;
use App\Models\Master\DocumentType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;  
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class BulkImport implements ToCollection, WithHeadingRow, WithValidation
{
      public $collection;  
    
      public function collection(Collection $rows)
      {
       
        foreach($rows as $row)
        {
            $academic_id = academicYearId();
            $institute_code=trim($row['institution_code']);
            $division_name=trim($row['division']);
            $check_institute_code   = Institution::where('code', $institute_code)->first();
            if($check_institute_code)
            {
                $institute_id=$check_institute_code->id;
            }
            else
            {
                $institute['code'] = $row['institution_code'];
                $institute['name'] = $row['institute_name'];
                $institute['academic_id'] = $academic_id;
                $institute['society_id'] = $academic_id;
                $institute_id = Institution::create($institute)->id;
            }
            $check_division_name  = Division::where('name', $division_name)->first();
            if($check_division_name)
            {
                $division_id=$check_division_name->id;
            }
            else
            {                
                $division['name'] = $division_name;
                $division['academic_id'] = $academic_id;
                $division_id = Division::create($division)->id;
            }
            if($row['aadhaar_card_name'] and $row['aadhaar_card_no'])
            {
                $aadhar_document_id=DocumentType::Where('name','Adhaar')->orWhere('name','Aadhaar')->orWhere('name','Aadhar')->first();
               if($aadhar_document_id)
               {
                    $aadhar_id=$aadhar_document_id->id;
               }
               else
               {
                
               }
            }
           
            $aadhar_document_id=
            $staff_personal= [ 
            'name' => $row['name_in_english'],
            'email' => $row['email_id'],
            'institute_id' => $institute_id,
            'academic_id' => $academic_id,
            'emp_code' => $row['employee_previous_code'],
            'first_name_tamil' => $row['name_in_tamil'],
            'short_name' =>  $row['short_name'],  
            'division_id' => $division_id,
            'reporting_manager_id' => $row['reporting_manager'],
            'status' => 'active',
            ];

             User::updateOrCreate(['emp_code' => $row['employee_previous_code']], $staff_personal);
        }
      }
    public function rules(): array
    {
        return [
            'employee_previous_code'        => 'required',
            'institute_name'                => 'required',
            'institution_code'              => 'required',
            'name_in_english'               => 'required',
            'email_id'                      => 'required',
            'class_handling'                => 'required',
            'division'                      => 'required',
            'date_of_birth'                 => 'required',
            'gender'                        => 'required',
            'marital_status'                => 'required',
            'mother_tongue'                 => 'required',
            'place_of_birth'                => 'required',
            'nationality'                   => 'required',
            'religion'                      => 'required',
            'caste'                         => 'required',
            'community'                     => 'required',
            'phone_no'                      => 'required',
            'emergency_no'                  => 'required',
            'contact_address'               => 'required',
            'permanent_address'             => 'required',
        ];
    }
}
