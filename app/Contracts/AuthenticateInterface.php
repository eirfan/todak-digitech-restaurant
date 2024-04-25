<?php 

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthenticateInterface {
    public function login(Request $request):bool;
}