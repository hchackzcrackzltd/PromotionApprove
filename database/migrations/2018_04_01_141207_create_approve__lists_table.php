<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApproveListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approve__lists', function (Blueprint $table) {
            $table->integer('pro_id');
            $table->integer('app_id');
            $table->string('user_id');
            $table->integer('seq');
            $table->string('name');
            $table->string('email');
            $table->text('remark')->nullable();
            $table->enum('status',[0,1,2,3])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approve__lists');
    }
}
