<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    private $response,$code,$class;

    public function __construct($response,$code=200,$class) {
        $this->response = $response;
        $this->code = $code;

        ## BOC : $class variable store the function name in which the api is executed, this is for debuggin purposes
        $this->class = $class;

        ## EOC

    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->response;
    }
    public function with($request) {
        return [
            'status'=>'success',
            'code'=>200,
            'class'=>$this->class,
        ];
    }
}
