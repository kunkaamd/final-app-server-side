<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreatePostTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('post',function(Blueprint $table){
            $table->increments("id");
            $table->string("title");
            $table->text("content");
            $table->string("image")->nullable();
            $table->string("author")->nullable();
            $table->string("view_count")->nullable();
            $table->enum("published", ["yes", "no"])->nullable();
            $table->string("rate")->nullable();
            $table->string("source")->nullable();
            $table->integer("series_id")->references("id")->on("series")->nullable();
            $table->integer("user_id")->references("id")->on("user")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post');
    }

}