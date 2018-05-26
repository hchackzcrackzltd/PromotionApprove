<?php

use Illuminate\Database\Seeder;
use App\Model\Masterdata\Promotion as prodb;

class promotion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        prodb::create([
          'name'=>'Other','createby'=>'report','inactive'=>0
        ]);
    }
}
