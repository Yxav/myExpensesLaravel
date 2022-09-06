<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Mail;
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

    public function create(array $data){
        return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => FacadesHash::make($data['password'])
      ]);
    }

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
            return response(200);
        }
        return response()->json("Incorrect credentials", 403);
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
     * This method will show form to reset password
     *
     * @return response()
     */
    public function showForgetPassword(){
       return view('forget_password');
    }

       /**
     * This method going to submit proccess to change password
     *
     * @return response()
     */
    public function submitRequestPasswordChange(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        FacadesDB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.reset_pass', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email)->subject('Redefina sua senha do app MyExpenses!');
        });

        return response(200);
    }

    public function showFormResetPassword(){
       return view('form_reset_password');
    }


    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $userFound = FacadesDB::table('password_resets')->where([
                    'token' => $request->token
                ])->first();
        if(!$userFound){
            return response()->json("fail", 500);
        }

        User::where('email', $userFound->email)->update(['password' => FacadesHash::make($request->password)]);
        FacadesDB::table('password_resets')->where(['email'=> $userFound->email])->delete();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                    ->withSuccess('You have Successfully loggedin');
        }
        return response(200);
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
