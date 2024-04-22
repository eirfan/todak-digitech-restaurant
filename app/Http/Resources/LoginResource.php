<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    private $token,$class;
    
    public function __construct($request,$token,$class) {
        parent::__construct($request);
        $this->token = $token;
        $this->class = $class;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'api_token'=>$this->token,
            'created_at'=>$this->create_at,
            'mobile'=>$this->mobile,
        ];
    }
    public function with($request) {
        return [
            'status'=>'success',
            'code'=>200,
            'class'=>$this->class,
        ];
    }
}
