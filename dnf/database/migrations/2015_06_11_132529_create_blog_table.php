<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  //文章的分类
	  Schema::create('blog_categories',function($table){
		$table->increments('id'     );
		$table->TEXT( 'category'    );
          		 $table->TEXT('creator');
		$table->TEXT('updater');
		$table->integer('sort');
		$table->integer('created_at' );
		$table->integer('updated_at' );
		$table->softDeletes();
		$table->engine  = 'InnoDB'; //设置 engine 属性为表设置存储引擎

            });


          //文章
	  Schema ::create('blog_articles',function($table){

		$table->increments('id');
                $table->TEXT('author');
		$table->integer('category_id');
		$table->TEXT('updater');
		$table->TEXT('deleter');
		$table->TEXT('title' );
		$table->mediumText('description')->nullable();
		$table->Boolean('draft')->defualt(false);
		$table->integer('post_time');
		$table->integer('sort');
		$table->integer('view' )->default(0);
		$table->text('source');
		$table->text('content');
		$table->string('img_URL');
	        $table->integer('created_at');
                $table->Boolean('top')->defualt(false);
                $table->integer('updated_at');
		$table->softDeletes();

		$table->engine = 'InnoDB';
	});
}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_categories');
		Schema::drop('blog_aricles');
	}

}
