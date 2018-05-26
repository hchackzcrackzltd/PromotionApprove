<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approve1 extends Model
{
  use SoftDeletes;
    protected $fillable=['approves_id','seq','user_id','line','name','email'];
}
