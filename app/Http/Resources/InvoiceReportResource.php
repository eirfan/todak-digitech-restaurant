<?php

namespace App\Http\Resources;


class InvoiceReportResource extends BaseResource
{
    private $data,$summary;

    public function __construct($data,$summary, $code = 200, $class) {
        parent::__construct($data,$code,$class);
        $this->data = $data;
        $this->summary = $summary;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        return parent::toArray($this->data);
    }

    public function with($request) {
        // $request['summary'] =$this->summary;
        $summary = [
            'summary'=>$this->summary,
        ];
        return array_merge($summary,parent::with($request));
        // return [
        //     parent::with($request),
        //     'summary'=>$this->summary,
        // ];

    }
}
