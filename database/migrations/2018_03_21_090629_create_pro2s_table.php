<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePro2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro2s', function (Blueprint $table) {
            $table->integer('pro_id')->references('id')->on('pros')->onDelete('cascade');
            $table->integer('seq');
            $table->string('oitm_id');
            $table->string('uom');
            $table->integer('prom_id');
            $table->string('prom_etc')->nullable();
            $table->decimal('cost_price',13,4);
            $table->decimal('normal_price',13,4);
            $table->decimal('prom_price',13,4);
            $table->decimal('discount',13,4);
            $table->integer('avgpcs');
            $table->decimal('avgp',13,4);
            $table->integer('sfcpcs');
            $table->decimal('sfcp',13,4);
            $table->integer('actpcs')->nullable();
            $table->decimal('actp',13,4)->nullable();
            $table->decimal('growth',13,4);
            $table->decimal('comp',13,4);
            $table->integer('est');
            $table->decimal('tcomp',13,4);
            $table->decimal('ts',13,4);
            $table->decimal('tn',13,4);
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro2s');
    }
}
