<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('aboutus',function($table){
            $table->increments('id');
            $table->string('img_URL');
            $table->TEXT('name');
            $table->TEXT('creator');
            $table->DATE('time');
            $table->TEXT('introduction');
            $table->TEXT('updater');
            $table->string('blog');
            $table->string('email');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->softDeletes();
            $table->engine  = 'InnoDB';
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('aboutus');
	}

}
