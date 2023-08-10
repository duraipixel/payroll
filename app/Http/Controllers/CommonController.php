<?php

namespace App\Http\Controllers;

use App\Models\AttendanceManagement\LeaveHead;
use App\Models\Master\Bank;
use App\Models\Master\BankBranch;
use App\Models\Master\Society;
use App\Models\User;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function openAddModal(Request $request)
    {
        $form_type = $request->form_type;
        $bank_id = $request->bank_id ?? '';
        if( $form_type == 'intitution' ) {
            $title = 'Add Institution';
        } else {
            $title = 'Add '.ucfirst($form_type);
        }
        $society = Society::where('status', 'active')->get();
        $content = '';

        if( !empty( $bank_id )) {
            $banks = Bank::find($bank_id);
        }
        
        switch ($form_type) {
            case 'intitution':
                
                $content = view('pages.masters.institutes.add_edit_form', compact('society'));
                break;

            case 'division':
            
                $content = view('pages.masters.divisions.add_edit_form');
                break;

            case 'class':
        
                $content = view('pages.masters.classes.add_edit_form');
                break;
                
            case 'language':
    
                $content = view('pages.masters.languages.add_edit_form');
                break;
            case 'new_language':

                $content = view('pages.masters.new_languages.add_edit_form');
                break;
            
            case 'places':
                $content = view('pages.masters.places.add_edit_form');
                break;

            case 'other_places':
                $content = view('pages.masters.other_places.add_edit_form');
                break;
            
            case 'nationality':
                $content = view('pages.masters.nationality.add_edit_form');
                break;
                
            case 'family_nationality':
                $content = view('pages.masters.nationality.add_edit_form1');
                break;
            
            case 'religion':
                $content = view('pages.masters.religion.add_edit_form');
                break;
            
            case 'caste':
                $content = view('pages.masters.caste.add_edit_form');
                break;

            case 'community':
                $content = view('pages.masters.community.add_edit_form');
                break;

            case 'bank':
                $content = view('pages.masters.bank.add_edit_form');
                break;

            case 'bankbranch':
                $content = view('pages.masters.bankbranch.add_edit_form', compact('banks'));
                break;

            case 'designation':
                $content = view('pages.masters.designation.add_edit_form');
                break;
            case 'experience_designation':
                $content = view('pages.masters.experience_designation.add_edit_form');
                break;
            
            case 'department':
                $content = view('pages.masters.department.add_edit_form');
                break;
            
            case 'subject':
                $content = view('pages.masters.subject.add_edit_form');
                break;
            
            case 'scheme':
                $content = view('pages.masters.scheme.add_edit_form');
                break;
            case 'duty_class':
                $content = view('pages.masters.duty_classes.add_edit_form');
                break;
            case 'duty_type':
                $content = view('pages.masters.duty_types.add_edit_form');
                break;
            case 'other_school':
                $content = view('pages.masters.other_schools.add_edit_form');
                break;
            case 'experience_institute_name':
                $content = view('pages.masters.exp_institutes.add_edit_form');
                break;
            case 'training_topic':
                $content = view('pages.masters.training_topic.add_edit_form');
                break;
            case 'boards':
                $content = view('pages.masters.boards.add_edit_form');
                break;
            case 'main_subject':
                $content = view('pages.masters.main_subject.add_edit_form');
                break;
            case 'ancillary_subject':
                $content = view('pages.masters.ancillary_subject.add_edit_form');
                break;
            case 'professional_type':
                $content = view('pages.masters.professional_type.add_edit_form');
                break;
            case 'relationship':
                $content = view('pages.masters.relation_type.add_edit_form');
                break;
            case 'qualification':
                $content = view('pages.masters.qualification.add_edit_form');
                break;
            case 'blood_group':
                $content = view('pages.masters.blood_group.add_edit_form');
                break;
            case 'medic_blood_group':
                $content = view('pages.masters.blood_group.add_edit_form_medic');
                break;
            case 'relationship_working_type':
                $content = view('pages.masters.working_relationship_type.add_edit_form');
                break;
            case 'staff_category':
                $content = view('pages.masters.staff_category.add_edit_form');
                break;
            case 'nature_of_employeement':
                $content = view('pages.masters.nature_of_employeement.add_edit_form');
                break;
            case 'teaching_type':
                $content = view('pages.masters.teaching_type.add_edit_form');
                break;
            case 'place_of_work':
                $content = view('pages.masters.place_of_work.add_edit_form');
                break;
            case 'order_model':
                $content = view('pages.masters.appointment_order_model.add_edit_form');
                break;
            
            default:
                # code...
                break;
        }
       
        
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function getStaffInfo(Request $request)
    {
        $query = $request['query'];
        $data = [];
        if( $query ) {

            $data = User::with('position.designation')
                        ->where(function($q) use($query) {
                            $q->where('name', 'like', "%{$query}%");
                            $q->orWhere('emp_code', 'like', "%{$query}%");
                            $q->orWhere('institute_emp_code', 'like', "%{$query}%");
                            $q->orWhere('society_emp_code', 'like', "%{$query}%");
                        })
                        ->InstituteBased()
                        // ->Academic()                       
                        ->get();

        }

        return $data;

    }

    function getStaffLeaveInfo(Request $request) {
        
        $staff_id = $request['staff_id'];

        $data = User::with(['position.designation', 'reporting'])->find($staff_id);
        
        return array('data' => $data);
    }

    public function getLeaveForm(Request $request)
    {
        
        if( $request->leave_category_id ) {
            $heads = LeaveHead::find($request->leave_category_id);
            
            if( $heads ) {
                switch (strtolower($heads->name)) {
                    case 'el':
                        return view('pages.leave.request_leave.el_form');
                        break;
                    case 'eol':
                        return view('pages.leave.request_leave.el_form');
                        break;
                    case 'ml':
                        return view('pages.leave.request_leave.el_form');
                    default:
                        return '';
                        break;
                }
            }
        }
        dd( $request->all() );
    }

}

