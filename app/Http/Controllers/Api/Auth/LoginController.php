<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\AuthenticateInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\LoginResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticateUser;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authenticateService;

    public function __construct(AuthenticateInterface $authenticateInterface) {
        $this->authenticateService = $authenticateInterface;
    }

    public function login(Request $request) {
        
        try{
            if(!$this->authenticateService->login($request)) {
                throw new Exception("Unauthorized");
            };
            $user = Auth::user();
            $token = $user->sessionUpdate();

            return new LoginResource($user,$token,__FUNCTION__);
            
        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),401,__FUNCTION__);
        }

        
    }
   
}
