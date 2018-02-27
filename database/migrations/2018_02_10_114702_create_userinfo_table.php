<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();;
            $table->string('first_name', '100')->nullable();
            $table->string('last_name', '100')->nullable();
			$table->string('address')->nullable();
			$table->string('postal_code')->nullable();
			$table->string('city')->nullable();
			$table->string('country')->nullable();
			$table->foreign('user_id')
                            ->references('id')
                            ->on('users')
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
        Schema::dropIfExists('userinfo');
    }
}
