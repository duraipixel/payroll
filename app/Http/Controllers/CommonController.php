<?php

namespace App\Http\Controllers;

use App\Models\Master\Bank;
use App\Models\Master\BankBranch;
use App\Models\Master\Society;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function openAddModal(Request $request)
    {
        $form_type = $request->form_type;
        $bank_id = $request->bank_id ?? '';
        $title = 'Add '.ucfirst($form_type);
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
            
            case 'places':
                $content = view('pages.masters.places.add_edit_form');
                break;
            case 'other_places':
                $content = view('pages.masters.other_places.add_edit_form');
                break;
            
            case 'nationality':
                $content = view('pages.masters.nationality.add_edit_form');
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
            case 'training_topic':
                $content = view('pages.masters.training_topic.add_edit_form');
                break;
            default:
                # code...
                break;
        }
       
        
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
}
