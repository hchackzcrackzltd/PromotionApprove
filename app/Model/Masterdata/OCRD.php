<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;

class OCRD extends Model
{
    protected $table='OCRD';
    public $timestamps=false;
    protected $primaryKey='cardcode';

    public function scopeMysales($value,$data)
    {
      return $value->where('slpcode',$data);
    }
}
