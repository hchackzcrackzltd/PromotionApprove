<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pro2 extends Model
{
  use SoftDeletes;
    protected $fillable=['pro_id','seq','oitm_id','uom','prom_id','cost_price','normal_price','prom_price',
    'discount','avgpcs','avgp','sfcpcs','sfcp','growth','comp','est','tcomp','ts','tn','remark','actpcs','actp','prom_etc'];

    public function descpro()
    {
      return $this->hasOne(Masterdata\Promotion::class, 'code', 'prom_id');
    }
}
