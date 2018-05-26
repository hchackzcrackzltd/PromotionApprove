<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Authorize_Main extends Model
{
    protected $fillable=['username','isadmin','approve_id'];

    public function authorize()
    {
      return $this->hasMany(Authorize::class,'authorize_id');
    }

    public function approve_list()
    {
      return $this->hasOne(Masterdata\Approve::class,'id', 'approve_id');
    }

    public function approve_list1()
    {
      return $this->hasMany(Masterdata\Approve1::class,'approves_id', 'approve_id');
    }
}
