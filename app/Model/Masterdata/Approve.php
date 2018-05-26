<?php

namespace App\Model\Masterdata;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Masterdata\OCRD;

class Approve extends Model
{
  use SoftDeletes;
    protected $fillable=['name','createby','updateby'];

    public function approve1()
    {
      return $this->hasMany(Approve1::class, 'approves_id');
    }
}
