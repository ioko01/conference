<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Kota;
use App\Models\Position;
use Illuminate\Foundation\Auth\RegistersUsers;
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
    protected $redirectTo = 'employee/research';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        $kotas = Kota::get();
        $positions = Position::get();

        return view('auth.register', compact('kotas', 'positions'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'prefix' => 'required|string',
            'fullname' => 'required|string',
            'sex' => 'required',
            'phone' => 'required|string|max:10',
            'institution' => 'required|string',
            'address' => 'required|string',
            'position_id' => 'required',
            'person_attend' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'prefix' => $data['prefix'],
            'fullname' => $data['fullname'],
            'sex' => $data['sex'],
            'phone' => $data['phone'],
            'institution' => $data['institution'],
            'address' => $data['address'],
            'position_id' => $data['position_id'],
            'kota_id' => isset($data['kota_id']) ? $data['kota_id'] : null,
            'person_attend' => $data['person_attend'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}