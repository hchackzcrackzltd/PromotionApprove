<?php

use Illuminate\Database\Seeder;
use App\Model\Masterdata\Approve as apdb;
use App\Model\Masterdata\Approve1;

class approve extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=apdb::create(['name'=>'Approve1','createby'=>'report']);
        Approve1::create(['approves_id'=>$data->id,'seq'=>1,'user_id'=>'DDD00699']);
        Approve1::create(['approves_id'=>$data->id,'seq'=>2,'user_id'=>'DDD00518']);
        Approve1::create(['approves_id'=>$data->id,'seq'=>3,'user_id'=>'DDD00408']);
    }
}
