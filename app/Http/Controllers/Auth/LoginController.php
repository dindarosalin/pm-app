<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Models\Auth\LoginModel;

class LoginController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // Validate & auto redirect when fail
        $rules = [
            'email'                 => 'required',
            'password'              => 'required|min:8|max:20',
            // 'g-recaptcha-response'  => 'required|recaptchav3:register,0.5',
        ];
        $this->validate($request, $rules);

        // Attempt to find the user by email
        $user = User::where('user_email', $request->email)->first();
        if ($user && password_verify($request->password, $user->user_password)) {
            if ($user->user_active == 1) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('start');
            }
        }
        else{
            $request->session()->flash('danger', 'Masuk gagal, silahkan cek kembali Email & Kata Sandi Anda.');
            return redirect('/login')->withInput();
        }
    }
}
