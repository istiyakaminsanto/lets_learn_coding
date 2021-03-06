<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        // Validator

        $inputs = $request->except('_token');

        $validator = Validator::make($inputs, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($inputs)) {

            // validation successful!
            // redirect them to the secure section or whatever
            // return Redirect::to('secure');
            // for now we'll just echo success (even though echoing in a controller is bad)
            session()->flash('message', 'You Have beeb successfully loged in');
            return Redirect::to('dashboard');

        } else {

            // validation not successful, send back to form
            session()->flash('message', 'Something went to wrong');
            return Redirect::to('loginform');

        }

    }

    public function logOut(){
        Auth::logout();
        return Redirect::to('loginform');
    }
}
