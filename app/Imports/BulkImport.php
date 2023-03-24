<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Master\Institution;
use App\Models\Master\Division;
use App\Models\Master\DocumentType;
use App\Models\Master\Classes;
use App\Models\Master\Language;
use App\Models\Master\Nationality;
use App\Models\Master\OtherSchoolPlace;
use App\Models\Master\Religion;
use App\Models\Master\Caste;
use App\Models\Master\Community;
use App\Models\Master\Bank;
use App\Models\Master\BankBranch;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffBankDetail;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffPfEsiDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;  
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterImport;
use Carbon\Carbon;

class BulkImport implements ToCollection, WithHeadingRow, WithValidation
{
      public $collection;  
    
      public function collection(Collection $rows)
      {       
        
        foreach($rows as $row)
        { 
          
            $academic_id = academicYearId();
            //Wizard First Start 

            //Check Institution Start
            $institute_code=trim($row['institution_code']);           
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
            //Check Institution End

            //Check Division Start
            $division_name=trim($row['division']);
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
            //Check Division End
            
            // Staff document details insert start
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

           $staff=  User::updateOrCreate(['emp_code' => $row['employee_previous_code']], $staff_personal);
           $staff_id=$staff->id;
            // Staff document details insert end

           //Check Aadhaar Start
           if($row['aadhaar_card_name'] and $row['aadhaar_card_no'])
           {
               $aadhar_check=DocumentType::Where('name','Adhaar')->orWhere('name','Aadhaar')->orWhere('name','Aadhar')->first();
               if($aadhar_check)
               {
                   $aadhar_id=$aadhar_check->id;
               }
               else
               {
                   $aadhaar['name'] = 'Aadhaar';
                   $aadhar_id = DocumentType::create($aadhaar)->id;
               }
               // Aadhaar details insert start
               $staff_aadhaar= [ 
                'academic_id' => $academic_id,
                'staff_id' => $staff_id,
                'document_type_id' => $aadhar_id,
                'description' => $row['aadhaar_card_name'],  
                'doc_number' =>  $row['aadhaar_card_no'],
                'verification_status' => 'pending',
                ];
               StaffDocument::updateOrCreate(['staff_id' => $staff_id, 'document_type_id' => $aadhar_id], $staff_aadhaar);
                // Aadhaar details insert end
           }
           //Check Aadhaar End

           //Check Pan Card Start
           if($row['pan_card_name'] and $row['pan_card_name'])
           {
               $pancard_check=DocumentType::Where('name','Pan Card')->first();
               if($pancard_check)
               {    
                   $pancard_id=$pancard_check->id;
               }
               else
               {
                   $pancard['name'] = 'Pan Card';
                   $pancard_id = DocumentType::create($pancard)->id;
               }
                // Pan card details insert start
                $staff_pancard= [ 
                    'academic_id' => $academic_id,
                    'staff_id' => $staff_id,
                    'document_type_id' => $pancard_id,
                    'description' => $row['pan_card_name'],  
                    'doc_number' =>  $row['pan_card_name'],
                    'verification_status' => 'pending',
                    ];
                   StaffDocument::updateOrCreate(['staff_id' => $staff_id, 'document_type_id' => $pancard_id], $staff_pancard);
                    // Pan card details insert end
           }
           //Check Pan Card End

           //Check Ration Card Start
           if($row['ration_card_name'] and $row['ration_card_no'])
           {
               $rationcard_check=DocumentType::Where('name','Ration Card')->first();
               if($rationcard_check)
               {    
                   $rationcard_id=$rationcard_check->id;
               }
               else
               {
                   $rationcard['name'] = 'Ration Card';
                   $rationcard_id = DocumentType::create($rationcard)->id;
               }
                 // Ration card details insert start
                 $staff_rationcard= [ 
                    'academic_id' => $academic_id,
                    'staff_id' => $staff_id,
                    'document_type_id' => $rationcard_id,
                    'description' => $row['ration_card_name'],  
                    'doc_number' =>  $row['ration_card_no'],
                    'verification_status' => 'pending',
                    ];
                   StaffDocument::updateOrCreate(['staff_id' => $staff_id, 'document_type_id' => $rationcard_id], $staff_rationcard);
                    // Ration card details insert end
           }
           //Check Ration Card End

           //Check Driving License Start
           if($row['driving_licence_name'] and $row['driving_licence_no'])
           {
               $drivinglicence_check=DocumentType::Where('name','Driving License')->first();
               if($drivinglicence_check)
               {    
                   $drivinglicence_id=$drivinglicence_check->id;
               }
               else
               {
                   $drivinglicence['name'] = 'Driving License';
                   $drivinglicence_id = DocumentType::create($drivinglicence)->id;
               }
               // Driving License details insert start
               $staff_drivinglicence= [ 
                'academic_id' => $academic_id,
                'staff_id' => $staff_id,
                'document_type_id' => $drivinglicence_id,
                'description' => $row['driving_licence_name'],  
                'doc_number' =>  $row['driving_licence_no'],
                'verification_status' => 'pending',
                ];
               StaffDocument::updateOrCreate(['staff_id' => $staff_id, 'document_type_id' => $drivinglicence_id], $staff_drivinglicence);
                // Driving License details insert end
           }
           //Check Driving License End

           //Check Voter ID Start
           if($row['voter_id_name'] and $row['voter_id_no'])
           {
               $voterid_check=DocumentType::Where('name','Voter ID')->first();
               if($voterid_check)
               {    
                   $voterid_id=$voterid_check->id;
               }
               else
               {
                   $voterid['name'] = 'Voter ID';
                   $voterid_id = DocumentType::create($voterid)->id;
               }
               // Voter ID details insert start
               $staff_voterid= [ 
                'academic_id' => $academic_id,
                'staff_id' => $staff_id,
                'document_type_id' => $voterid_id,
                'description' => $row['voter_id_name'],  
                'doc_number' =>  $row['voter_id_no'],
                'verification_status' => 'pending',
                ];
               StaffDocument::updateOrCreate(['staff_id' => $staff_id, 'document_type_id' => $voterid_id], $staff_voterid);
                // Driving License details insert end
           }
           //Check Voter ID End

           //Check Passport Start
           if($row['passport_name'] and $row['passport_no'])
           {
               $passport_check=DocumentType::Where('name','Passport')->first();
               if($passport_check)
               {    
                   $passport_id=$passport_check->id;
               }
               else
               {
                   $passport['name'] = 'Voter ID';
                   $passport_id = DocumentType::create($passport)->id;
               }
                // Passport details insert start
                $staff_passport= [ 
                    'academic_id' => $academic_id,
                    'staff_id' => $staff_id,
                    'document_type_id' => $passport_id,
                    'description' => $row['passport_name'],  
                    'doc_number' =>  $row['passport_no'],
                    'verification_status' => 'pending',
                    ];
                   StaffDocument::updateOrCreate(['staff_id' => $staff_id, 'document_type_id' => $passport_id], $staff_passport);
                    // Passport details insert end
           }
           //Check Passport End
           
           //Check Class start 
           $class_handling_excel=$row['class_handling'];
           $classes=explode(",",$class_handling_excel);
           foreach($classes as $class)
           {
                $class_check=Classes::where('name', $class)->first();
                if($class_check)
                {
                    $class_id=$class_check->id;
                     //Class handlings insert start  
                    $staff_class= [ 
                        'academic_id' => $academic_id,
                        'staff_id' => $staff_id,
                        'class_id' =>$class_id, 
                        ];
                        StaffClass::create($staff_class);                  
                    //Class handlings insert end  
                }
                else
                {
                    $class_insert['academic_id'] = $academic_id;
                    $class_insert['name'] = $class;
                    $class_insert_data=Classes::create($class_insert);     
                    $class_insert_id=$class_insert_data->id;
                     //Class handlings insert start  
                     $staff_class= [ 
                        'academic_id' => $academic_id,
                        'staff_id' => $staff_id,
                        'class_id' =>$class_insert_id, 
                        ];
                        StaffClass::create($staff_class);                  
                    //Class handlings insert end  
                }
           }
           //Check Class  end  
           // Wizard First End 

           // Wizard Second Start
           // Check Language Start
           $lanuguage_check=Language::where('name',$row['mother_tongue'])->first();
           if($lanuguage_check)
           {
                $language_id=$lanuguage_check->id;
           }
           else
           {
                $lanuguage_insert= [ 
                    'academic_id' => $academic_id,
                    'name' => $row['mother_tongue'],
                    ];
                $language_id=Language::create($lanuguage_insert)->id;     
           }
           // Check Language End

            // Check Place of Birth Start
           $place_of_birth_check=OtherSchoolPlace::where('name',$row['place_of_birth'])->first();
           if($place_of_birth_check)
           {
                $place_of_birth_id=$place_of_birth_check->id;
           }
           else
           {
                $place_of_birth_insert= [ 
                    'academic_id' => $academic_id,
                    'name' => $row['place_of_birth'],
                    ];
                $place_of_birth_id=OtherSchoolPlace::create($place_of_birth_insert)->id;     
           }     
            // Check Place of Birth  End

           // Check Nationality Start
           $nationality_check=Nationality::where('name',$row['nationality'])->first();
           if($nationality_check)
           {
                $nationality_id=$nationality_check->id;
           }
           else
           {
                $nationality_insert= [ 
                    'academic_id' => $academic_id,
                    'name' => $row['nationality'],
                    ];
                $nationality_id=Nationality::create($nationality_insert)->id;     
           }     
            // Check Nationality  End

           // Check Religion Start
           $religion_check=Religion::where('name',$row['religion'])->first();
           if($religion_check)
           {
                $religion_id=$religion_check->id;
           }
           else
           {
                $religion_insert= [ 
                    'academic_id' => $academic_id,
                    'name' => $row['religion'],
                    ];
                $religion_id=Religion::create($religion_insert)->id;     
           }     
            // Check Religion  End
           // Check Caste Start
           $caste_check=Caste::where('name',$row['caste'])->first();
           if($caste_check)
           {
                $caste_id=$caste_check->id;
           }
           else
           {
                $caste_insert= [ 
                    'academic_id' => $academic_id,
                    'name' => $row['caste'],
                    ];
                $caste_id=Caste::create($caste_insert)->id;     
           }     
           // Check Caste  End 

           // Check Community Start
           $community_check=Community::where('name',$row['community'])->first();
           if($community_check)
           {
                $community_id=$community_check->id;
           }
           else
           {
                $community_insert= [ 
                    'academic_id' => $academic_id,
                    'name' => $row['community'],
                    ];
                $community_id=Community::create($community_insert)->id;     
           }     
           // Check Religion  End 
           if($row['ifsc_code'] and $row['account_number'])
           {
           // Check Bank and Branch Start
                $bank_check=BankBranch::where('ifsc_code',$row['ifsc_code'])->first();
                if($bank_check)
                {
                        $branch_id=$bank_check->id;
                        $bank_id=$bank_check->bank_id;
                }
                else
                {
                        $bank_insert= [ 
                            'academic_id' => $academic_id,
                            'name' => $row['bank_name'],
                            ];
                        $bank_id=Bank::create($bank_insert)->id;
                        $branch_insert= [ 
                            'academic_id' => $academic_id,
                            'name' => $row['branch_name'],
                            'bank_id' => $bank_id,
                            'ifsc_code' => $row['ifsc_code'],
                            ];
                        $branch_id=BankBranch::create($branch_insert)->id;       
                } 
                //Staff ank details insert start
                $account_insert= [ 
                    'academic_id' => $academic_id,
                    'staff_id' => $staff_id,
                    'bank_id' => $bank_id,
                    'bank_branch_id' => $branch_id,
                    'account_number' => $row['account_number'],
                    'account_name' => $row['account_name'],
                    ];
                StaffBankDetail::updateOrCreate(['staff_id' => $staff_id], $account_insert);
                 //Staff ank details insert end
            }
           // Check Bank and Branch  End 

           //Staff UAN Details insert Start
           if($row['uan_no'])
           {
                $uan_insert= [ 
                    'academic_id' => $academic_id,
                    'staff_id' => $staff_id,
                    'ac_number' => $row['uan_no'],
                    'type' => 'pf',
                    'start_date' => $row['uan_start_date'] ? date('Y-m-d', strtotime($row['uan_start_date'])) : null,
                    'location' => $row['uan_area'],
                    'status' =>  'active',
                    ];
                    StaffPfEsiDetail::updateOrCreate(['staff_id' => $staff_id, 'type' => 'pf'], $uan_insert);
           }
           //Staff UAN Details insert End

           //Staff ESI Details insert Start
           if($row['esi_no'])
           {
                $esi_insert= [ 
                    'academic_id' => $academic_id,
                    'staff_id' => $staff_id,
                    'ac_number' => $row['esi_no'],
                    'type' => 'esi',
                    'start_date' => $row['esi_start_date'] ? date('Y-m-d', strtotime($row['esi_start_date'])) : null,
                    'end_date' => $row['esi_end_date'] ? date('Y-m-d', strtotime($row['esi_end_date'])) : null,
                    'location' => $row['esi_area'],
                    'status' =>  'active',
                    ];
                    StaffPfEsiDetail::updateOrCreate(['staff_id' => $staff_id, 'type' => 'esi'], $esi_insert);
           }
           //Staff ESI Details insert end

           // Staff Personal details insert start
            $staff_personal_details= [
                 'academic_id' => $academic_id, 
                  'staff_id'  => $staff_id,
                  'dob' => date('Y-m-d', strtotime($row['date_of_birth'])),
                  'mother_tongue' => $language_id,
                  'gender' => strtolower($row['gender']),
                  'marital_status' => strtolower($row['marital_status']), 
                  'marriage_date' => strtolower($row['marital_status']) == 'married' ? date('Y-m-d', strtotime($row['marriage_date'])) : null,
                  'birth_place' => $place_of_birth_id,
                  'nationality_id' => $nationality_id,
                  'religion_id' => $religion_id,
                  'caste_id'  => $caste_id,
                  'community_id'  => $community_id,
                  'phone_no' => $row['phone_no'],
                  'mobile_no1' => $row['mobile_no1'],
                  'mobile_no2' => $row['mobile_no2'],
                  'whatsapp_no' => $row['whatsapp_no'],
                  'emergency_no' => $row['emergency_no'],
                  'contact_address' => $row['contact_address'],
                  'permanent_address' => $row['permanent_address'] ,
                  'status' => 'active',
                ];

           StaffPersonalInfo::updateOrCreate(['staff_id' => $staff_id], $staff_personal_details);
           // Staff Personal details insert end  

           // Wizard Second End
        }
    }
    public function rules(): array
    {
        return [
            'employee_previous_code'        => 'required',
            'institute_name'                => 'required',
            'institution_code'              => 'required',
            'name_in_english'               => 'required',
            'email_id'                      => 'required|string|unique:users,email',
            'class_handling'                => 'required',
            'division'                      => 'required',
            'date_of_birth'                 => 'required',
            'gender'                        => 'required',
            'marital_status'                => 'required',
            'marriage_date' => 'required_if:marital_status,==,married',
            'mother_tongue'                 => 'required',
            'place_of_birth'                => 'required',
            'nationality'                   => 'required',
            'religion'                      => 'required',
            'caste'                         => 'required',
            'community'                     => 'required',
            'contact_address'               => 'required',
            'permanent_address'             => 'required',
            'phone_no' => 'required|numeric|digits:10',
            'emergency_no' => 'required|numeric|digits:10',
            'mobile_no_1' => 'nullable|numeric|digits:10',
            'mobile_no_2' => 'nullable|numeric|digits:10',
            'whatsapp_no' => 'nullable|numeric|digits:10',
        ];
    }
    public function getRowCount(): int
    {
        return $this->rows; 
    }
    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                dump($this->finaldata);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            // F is the column
            'L' => '0',
            'AR' => '0'
        ];
    }
}
