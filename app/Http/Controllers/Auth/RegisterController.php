<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'access_level' => ['required', 'numeric', 'max:1']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'access_level' => $data['access_level']
            // 'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, User $user) {
        $user->generateActivationToken();
    
        return response()->json(['data' => $user->toArray()], 201);
    }

    public function activate(Request $request) {
        $error_msgs = [
            'required' => 'The :attribute is required',
            'size' => 'The :attribute is not valid'
        ];
        
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'activation_token' => ['required', 'string', 'size:10']
        ],
        $error_msgs
        );

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()]);
        }
        // $validate_request = $request->validate([
        //     'email' => ['required', 'string', 'email', 'max:255'],
        //     'activation_token' => ['required', 'string', 'max:10']
        // ]);
        $user  = User::where('email', $request->email)->firstOrFail();

        if ($user->activation_token === $request->activation_token
            && $user->activation_token !== null) {
            $user->activation_token = null;
            $user->active = 1;
            $user->save();

            return response()->json(['data' => $user->toArray()], 200);
        } else {
            return response()->json(['data' => 'Invalid token'], 403);
        }
    }
}
