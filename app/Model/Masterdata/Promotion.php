<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
  use SoftDeletes;
    protected $primaryKey='code';
    protected $fillable=['name','createby','updateby','inactive'];

    public function scopeOther($value)
    {
      return $value->where('code','<>',1);
    }

    public function scopeInactive($value)
    {
      return $value->where('inactive',0);
    }
}
