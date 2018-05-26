<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
  use SoftDeletes;
    protected $fillable=['name','createby','updateby','inactive'];

    public function scopeInactive($value)
    {
      return $value->where('inactive',0);
    }
}
