<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprove1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approve1s', function (Blueprint $table) {
            $table->integer('approves_id')->references('id')->on('approves')->onDelete('cascade');
            $table->integer('seq');
            $table->integer('line');
            $table->string('user_id');
            $table->string('name');
            $table->string('email');
            $table->softDeletes();
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
        Schema::dropIfExists('approve1s');
    }
}
