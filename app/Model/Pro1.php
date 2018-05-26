<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pro1 extends Model
{
  use SoftDeletes;
    protected $fillable=['pro_id','exp_id','value'];

    public function descexp()
    {
      return $this->hasOne(Masterdata\Expense::class,'id','exp_id');
    }
}
