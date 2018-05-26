<?php

use Illuminate\Database\Seeder;
use App\Model\Masterdata\Expense as exdb;

class expense extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        exdb::create([
          'name'=>'test1','createby'=>'report','inactive'=>0
        ]);
    }
}
