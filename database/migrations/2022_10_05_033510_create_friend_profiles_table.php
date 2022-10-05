<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_profiles', function (Blueprint $table) {
            $table->primary(['profile_id','friend_id'] );
            $table->unsignedInteger('profile_id');
            $table->unsignedInteger('friend_id');
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('profiles')->onDelete('cascade');
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend_profiles');
    }
};
