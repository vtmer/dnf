<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		       Schema::create('blog_tag',function(Blueprint $table)
                 {
                    $table->increments('id');
                    $table->string('tag');
                    $table->TEXT('creator');
                    $table->TEXT('updater');
                    $table->integer('created_at');
                    $table->integer('updated_at');
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('blog_tag');
	}

}
