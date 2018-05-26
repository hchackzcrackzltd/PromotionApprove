<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class oitmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'name'=>$this->name,'uom'=>$this->uom,'uom2'=>$this->uom2,'cost'=>$this->cost,'normal'=>$this->normal_price,'conv'=>$this->convert
        ];
    }
}
