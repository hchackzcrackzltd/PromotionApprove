<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pro2_view extends Model
{
    public function descpro()
    {
      return $this->hasOne(Masterdata\Promotion::class, 'code', 'prom_id');
    }
}
