<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_user_que', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('QUE_ID')->comment('自增主键');
            $table->integer('USER_ID')->comment('用户ID')->unsigned();
            $table->string('USER_QUE',64)->comment('验证问题');
            $table->string('USER_ANS',64)->comment('验证答案');
        });
        //添加外键
        Schema::table('d_user_que', function(Blueprint $table) {
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
        Schema::dropIfExists('d_user_que');
    }
}
