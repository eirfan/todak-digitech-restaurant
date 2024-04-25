<?php 

namespace App\Services;

use App\Contracts\AuthenticateInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateServices implements AuthenticateInterface {
    public function login(Request $request):bool
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password'=>'required',
        ]);
        
        if(!$this->authenticate($request->all())) {
            return false;
        };
        // $user = Auth::user();
        // $user->sessionUpdate();
        return true;
    }
    private function authenticate($credentials) {
        if (Auth::attempt($credentials) ) {
            return true;
        }
        return false;
    }
}