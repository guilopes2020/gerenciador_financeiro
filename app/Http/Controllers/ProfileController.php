<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    protected $userLogged;

    public function index() {
        $this->userLogged = Auth::id();

        $user = User::find($this->userLogged);

        if ($user) {
            return view('profile', [
                'user' => $user
            ]);
        } else {
            return redirect()->route('entriesIndex');
        }
 
    }

    public function update(Request $request) {

        $this->userLogged = Auth::id();
        $user = User::find($this->userLogged);

        if ($user) {
            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);
    
            $validator = $this->validator($data);
    
            if ($validator->fails()) {
                return redirect()->route('profile')->withErrors($validator)->withInput();
            }

            $user->name = $data['name'];

            if ($user->email != $data['email']) {
                $hashEmail = User::where('email', $data['email'])->get();
                if (count($hashEmail) === 0) {
                    $user->email = $data['email'];
                } else {
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email'
                    ]));
                }
            }
            
            if (!empty($data['password'])) {
                if (strlen($data['password']) >=4) {
                    if ($data['password'] === $data['password_confirmation']) {
                        $user->password = Hash::make($data['password']);
                    } else {
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password'
                        ]));
                    }
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            }

            if (count($validator->errors()) > 0) {
                return redirect()->route('profile', [
                    'user' => $user
                ])->withErrors($validator);
            }

            $user->save();
            return redirect()->route('profile')->with('warning', 'Perfil alterado com sucesso');

        } else {
            return redirect()->route('profile');
        }

        
    }

    protected function validator(array $data) {
        return Validator::make($data, [
          'name' => ['required', 'string', 'max:100'],
          //'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
          //'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }
}
