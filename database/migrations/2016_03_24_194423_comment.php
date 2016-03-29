<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table) {
            $table->string('id', 11);
            $table->primary('id');
            $table->text('content');
            $table->string('on_post', 11);
            $table->foreign('on_post')
                  ->references('id')->on('posts')
                  ->onDelete('cascade');
            $table->integer('from_user')->unsigned()->default(0);
            $table->foreign('from_user')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
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
        Schema::drop('comments');
    }
}
