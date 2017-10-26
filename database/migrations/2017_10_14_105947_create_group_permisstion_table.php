<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateGroupPermisstionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('grouppermisstion',function(Blueprint $table){
            $table->increments("id");
            $table->integer("group_id")->references("id")->on("group");
            $table->integer("permission_id")->references("id")->on("permission");
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
        Schema::drop('grouppermisstion');
    }

}