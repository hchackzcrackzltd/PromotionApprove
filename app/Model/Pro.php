<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pro extends Model
{
    use SoftDeletes;
    protected $fillable=['account_group','account_id','str_date','end_date','desc','remark','createby','updateby','approve','status'];

    public function Pro1()
    {
      return $this->hasMany(Pro1::class, 'pro_id');
    }

    public function Pro2()
    {
      return $this->hasMany(Pro2::class, 'pro_id');
    }

    public function Pro2_item()
    {
      return $this->hasMany(Pro2_item::class, 'pro_id');
    }

    public function list_approve()
    {
      return $this->hasMany(Approve_List::class, 'pro_id');
    }
}
