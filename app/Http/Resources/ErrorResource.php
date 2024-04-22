<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    private $errorMessage,$code,$class;
    public function __construct($errorMessage,$code=404,$class) {
        $this->errorMessage = $errorMessage;
        $this->code = $code;
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
        return [];
    }
    public function with($request) {
        return [
            'status'=>'failed',
            'message'=>$this->errorMessage,
            'code'=>$this->code,
            'class'=>$this->class,     
        ];
    }
}
