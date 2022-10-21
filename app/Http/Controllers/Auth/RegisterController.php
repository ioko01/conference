<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Kota;
use App\Models\Position;
use App\Models\Tip;
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
    protected $redirectTo = 'employee/research/send';

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
        $conference_id = Conference::where('status_research', 1)->first();
        $tips = Tip::where('group', '1')->get();

        return view('auth.register', compact('kotas', 'positions', 'conference_id', 'tips'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data["person_attend"] == "attend") {
            return Validator::make($data, [
                'prefix' => 'required|string',
                'fullname' => 'required|string',
                'sex' => 'required',
                'phone' => 'required|string|max:10',
                'institution' => $data['position_id'] == '2' ? 'required|string' : 'string',
                'position_id' => 'required',
                'person_attend' => 'required',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
        } else if ($data["person_attend"] == "send") {
            return Validator::make($data, [
                'prefix' => 'required|string',
                'fullname' => 'required|string',
                'sex' => 'required',
                'phone' => 'required|string|max:10',
                'institution' => $data['position_id'] == '2' ? 'required|string' : 'string',
                'address' => 'required|string',
                'position_id' => 'required',
                'person_attend' => 'required',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'receive_check' => 'required'
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $conference_id = Conference::where('status', 1)->first();


        if ($data['position_id'] == '1') {
            $institution = 'มหาวิทยาลัยราชภัฏเลย';
        } elseif ($data['position_id'] == '3') {
            if (isset($data['kota_id'])) {
                $kota = Kota::find($data['kota_id']);
                $institution = $kota->name;
            }
        } else {
            $institution = $data['institution'];
        }

        return User::create([
            'prefix' => $data['prefix'],
            'fullname' => $data['fullname'],
            'sex' => $data['sex'],
            'phone' => $data['phone'],
            'institution' => $institution,
            'address' => $data['address'],
            'check_requirement' => $data['receive_check'],
            'position_id' => $data['position_id'],
            'kota_id' => isset($data['kota_id']) ? $data['kota_id'] : null,
            'person_attend' => "send",
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'conference_id' => isset($conference_id->id) ? $conference_id->id : null
        ]);
    }
}
