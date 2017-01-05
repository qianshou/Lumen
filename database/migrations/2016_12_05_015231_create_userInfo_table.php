<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_user_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('USER_ID')->comment('自增主键');
            $table->string('USER_PHONE',32)->comment('手机号');
            $table->string('USER_NAME',32)->comment('用户名');
            $table->string('USER_PWD',32)->comment('密码');
            $table->char('USER_SEX',4)->comment('性别');
            $table->smallInteger('USER_AGE')->comment('年龄');
            $table->float('USER_HEI')->comment('身高');
            $table->float('USER_WEI')->comment('体重');
            $table->dateTime('USER_BRI')->comment('出生日期');
            $table->string("USER_IMG",255)->comment('头像路径');
            $table->dateTime('RGE_TIME')->default(\DB::raw('CURRENT_TIMESTAMP'))->comment('注册时间');
            $table->unique('USER_PHONE');
            $table->unique('USER_NAME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_user_info');
    }
}
