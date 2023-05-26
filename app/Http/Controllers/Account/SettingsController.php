<?php

namespace App\Http\Controllers\Account;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $breadcrums = array(
            'title' => 'Settings',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Account - Settings'
                ),
            )
        );
        $staff_id = auth()->user()->id;
        return view('pages.account.settings',compact('breadcrums'));
    }
    
}
