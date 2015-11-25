<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticleTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_tag',function(Blueprint $table)
    {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('article_id')->unsigned()->index();

            $table->integer('tag_id'    )->unsigned()->index();
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('article_tag');
    }

}
