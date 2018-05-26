<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Authorize extends Model
{
    protected $fillable=['authorize_id','funct_id','permit'];
    public $timestamps=false;
}
