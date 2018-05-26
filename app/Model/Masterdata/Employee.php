<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection='mysql';
    protected $table='employees';
    protected $primaryKey='code';
    protected $fillable=['salecode'];
    public $timestamps=false;
}
