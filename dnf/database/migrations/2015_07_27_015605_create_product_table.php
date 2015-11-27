<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('product',function($table){
            $table->increments('id');
            $table->TEXT('name');
            $table->TEXT('description');
            $table->TEXT('holder');
            $table->TEXT('img_URL');
            $table->string('url');
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
        Schema::drop('product');
	}

}
