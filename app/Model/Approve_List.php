<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Approve_List extends Model
{
    protected $fillable=['pro_id','user_id','seq','status','app_id','name','email','remark'];

    public function scopeMyapprove($value)
    {
      return $value->where(['status'=>1,'user_id'=>auth()->user()->username]);
    }

    public function scopeListapprove($value)
    {
      if (auth()->user()->Authorize_Main()->first()->isadmin) {
        return $value;
      }else {
        return $value->where('user_id',auth()->user()->username);
      }
    }

    public function scopeReject($value)
    {
      return $value->where('status',3);
    }

    public function promotion()
    {
      return $this->hasOne(Pro::class, 'id', 'pro_id');
    }

    public function pro()
    {
      return $this->hasOne(Pro_view::class, 'id', 'pro_id');
    }
}
