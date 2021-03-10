<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Programme;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
        $Programmes = Programme::all();
        return view('auth.register')->with('Programmes', $Programmes);
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
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:255'],
            'courriel' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'motDePasse' => ['required', 'string', 'min:6', 'confirmed'],
            'programme_id' => 'Required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $User = new User;
        $User->nom = $data['nom'];
        $User->prenom = $data['prenom'];
        $User->courriel = $data['courriel'];
        $User->numero = $data['numero'];
        $User->motDePasse = Hash::make($data['motDePasse']);
        $User->isAdmin = false;
        $User->programme_id = $data['programme_id'];
        $User->save();
        return $User;
    }
}