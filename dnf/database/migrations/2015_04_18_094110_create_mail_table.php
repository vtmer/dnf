<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('admin_mail', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->string('sender_name', 20);
            $table->string('receiver_name', 20);
            $table->string('content', 1000);
            $table->boolean('flag')->default(false)->comments('0表示未读，1表示已读');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->index('sender_id');
            $table->index('receiver_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('admin_mail');
	}

}
