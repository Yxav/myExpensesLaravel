<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Session as FacadesSession;

class AuthController extends Controller

{
    /**
     * Write code on Method
     *
     * @return response()
     */

    public function index(){
        return view('login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(){
        return view('register');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                    ->withSuccess('You have Successfully loggedin');
        }
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $this->create($data);
        $this->postLogin($request);
    }

    /**
     * Write code on Method
     *
     * @return response()
    */

    public function logout() {
        FacadesSession::flush();
        Auth::logout();
        return Redirect('login');
    }
}
