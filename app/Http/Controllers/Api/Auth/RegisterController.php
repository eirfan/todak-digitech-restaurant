<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\PaymentGatewayInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ErrorResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Foundation\Auth\RegistersUser;

class RegisterController extends Controller
{
    protected $paymentServices;
    public function __construct(PaymentGatewayInterface $paymentGatewayInterface) {
        $this->paymentServices = $paymentGatewayInterface;
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'roles'=>'required'
        ]);
        
        try{
            if($validator->fails()) {
                throw new Exception($this->parseValidationError($validator->errors()->all()));
            }
            DB::beginTransaction();
            $user = unserialize(serialize($request->all()));
            $user['password'] = Hash::make($request['password']);
            $newUser = User::create($user);
            if(!$newUser) {
                throw new Exception("Cannot create new user");
            }

            if(is_array($request->roles)) {
                foreach($request->roles as $role) {
                    $newUser->assignRole(config('base.role_id.'.$role));
                }
            }
            if(is_string($request->roles)) {
                $newUser->assignRole(config('base.role_id.'.$role));
            }

            if(!$this->paymentServices->createAccount($newUser)) {
                throw new Exception("Cannot create stripe account");
            };
            DB::commit();
            return new BaseResource($newUser,200,__FUNCTION__);

            
        }catch(Exception $exception) {
            DB::rollBack();
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }
    //
}
