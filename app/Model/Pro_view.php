<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pro_view extends Model
{
    public function Pro2()
    {
      return $this->hasMany(Pro2_view::class, 'pro_id');
    }

    public function Pro1()
    {
      return $this->hasMany(Pro1::class,'pro_id');
    }

    public function Approve_List()
    {
      return $this->hasMany(Approve_List::class,'pro_id');
    }

    public function scopeMyrequest($value)
    {
      $data=auth()->user()->load(['Authorize_Main','Authorize_Main.authorize']);
      if ($data->Authorize_Main->isadmin||$data->Authorize_Main->authorize->where('funct_id',0)->where('permit',0)->count()===1) {
        return $value;
      }else {
        return $value->where('createby',auth()->user()->username);
      }
    }

    public function getStrDateAttribute($value)
    {
      return Carbon::parse($value)->format('d/M/Y');
    }

    public function getEndDateAttribute($value)
    {
      return Carbon::parse($value)->format('d/M/Y');
    }

    public function getCreatedAtAttribute($value)
    {
      return Carbon::parse($value)->format('d/M/Y');
    }
}
