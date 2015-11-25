<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('course_articles',function($table){
            $table->increments('id');
            $table->integer('course_id');
            $table->TEXT('title');
            $table->TEXT('author');
            $table->TEXT('updater');
            $table->TEXT('deleter');
            $table->TEXT('content');
            $table->integer('view')->default(0);
            $table->Boolean('draft')->default(true);
            $table->string('img_URL');
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
        Schema::drop('course_articles');
	}

}
