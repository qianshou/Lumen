<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloodInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_blood_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('HI_ID')->comment('自增主键');
            $table->integer("USER_ID")->comment('用户编号')->unsigned();
            $table->float("BLOOD_OXYGEN")->comment('血氧浓度');
            $table->float("BLOOD_VISCOSITY")->comment('血液粘度');
            $table->integer("DBP")->comment('舒张压');
            $table->integer("SBP")->comment('收缩压');
            $table->dateTime("MERSURE_TIME")->comment('测量时间');
        });
        //添加外键
        Schema::table('d_blood_info', function(Blueprint $table) {
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
        Schema::dropIfExists('d_blood_info');
    }
}
