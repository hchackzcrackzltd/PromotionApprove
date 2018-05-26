<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OITM extends Model
{
    protected $table='OITM';
    public $timestamps=false;
    protected $primaryKey='code';
}
