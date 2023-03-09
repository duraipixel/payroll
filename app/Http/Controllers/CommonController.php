<?php

namespace App\Http\Controllers;

use App\Models\Master\Society;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function openAddModal(Request $request)
    {
        $form_type = $request->form_type;
        $title = 'Add '.ucfirst($form_type);
        $society = Society::where('status', 'active')->get();
        $content = '';

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
                
            default:
                # code...
                break;
        }
       
        
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
}
