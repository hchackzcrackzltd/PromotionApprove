<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;

class emp_proapp extends Model
{
    protected $connection='mysql';
    protected $table='emp_proapp';
    protected $primaryKey='code';
    public $timestamps=false;
}
