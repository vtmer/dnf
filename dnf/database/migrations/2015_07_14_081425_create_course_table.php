<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('course',function($table){
            $table->increments('id');
            $table->TEXT('name');
            $table->TEXT('creator');
            $table->TEXT('updater');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->softDeletes();
            $table->engine='InnoDB';
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('course');
	}

}
