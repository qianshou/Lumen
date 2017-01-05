<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBpmInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_bpm_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('BPM_ID')->comment('自增主键');
            $table->integer('USER_ID')->comment('用户ID')->unsigned();
            $table->integer('BPM')->comment('用户心率');
            $table->dateTime('MERSURE_TIME')->comment('测量时间');
        });
        //添加外键
        Schema::table('d_bpm_info', function(Blueprint $table) {
            $table->foreign('USER_ID')->references('USER_ID')->on('p_user_info')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_bpm_info');
    }
}
