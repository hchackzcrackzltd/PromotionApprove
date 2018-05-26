<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pros', function (Blueprint $table) {
            $table->increments('id');
            $table->json('account_group');
            $table->string('account_id');
            $table->date('str_date');
            $table->date('end_date');
            $table->text('desc');
            $table->text('remark')->nullable();
            $table->string('createby');
            $table->string('updateby')->nullable();
            $table->enum('approve',[0,1])->default(0);
            $table->enum('status', ['AC','NQ','WP','SC','CN']);
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
        Schema::dropIfExists('pros');
    }
}
