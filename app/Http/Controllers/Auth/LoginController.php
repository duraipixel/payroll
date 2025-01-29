<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            // Check database connection by executing a simple query
            \DB::connection()->getPdo();

            // If needed, you can log the connection name or database name
            $connection = \DB::connection()->getName();
            $database = \DB::connection()->getDatabaseName();

            \Log::info("Database connected successfully. Connection: {$connection}, Database: {$database}");
        } catch (\Exception $e) {
            // Handle database connection failure
            \Log::error("Database connection failed: " . $e->getMessage());

            // Optionally, abort the request or handle it gracefully
            abort(500, 'Database connection failed. Please check your configuration.');
        }

        // Example of setting session if the database connection is successful
        try {
            $academic = AcademicYear::where('status', 'active')->where('is_current', 1)->first();

            if ($academic) {
                Session::put('academic_id', $academic->id);
            }
        } catch (\Exception $e) {
            \Log::error("Failed to retrieve academic year: " . $e->getMessage());
        }

        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
       
        session(['staff_institute_id' => auth()->user()->is_super_admin ? 1 : auth()->user()->institute_id ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if( $request->email == 'payrolladmin@yopmail.com'){
            $credentials = $request->only('email', 'password');
        } else {
            $credentials = [
                'society_emp_code' => $request->get('email'), 
                'password' => $request->get('password'), 
            ];
        }
     
        if (Auth::attempt($credentials)) { 
            session(['staff_institute_id' => auth()->user()->is_super_admin ? 1 : auth()->user()->institute_id ]);

            return redirect()->route('home');
        }
    
        return redirect("login")->with('password','Opps! You have entered invalid credentials');
    }
}
