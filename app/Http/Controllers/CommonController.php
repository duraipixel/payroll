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

            default:
                # code...
                break;
        }
       
        
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
}
