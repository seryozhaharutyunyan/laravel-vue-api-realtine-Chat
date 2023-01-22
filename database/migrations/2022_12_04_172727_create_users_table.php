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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->date('age');
            $table->string('gender');
            $table->unsignedBigInteger('image_id');
            $table->string('password');
            $table->boolean('block')->default(false);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->index('country_id', 'user_country_idx');
            $table->foreign('country_id', 'user_country_fk')
                ->on('countries')->references('id');

            $table->index('image_id', 'user_image_idx');
            $table->foreign('image_id', 'user_image_fk')
                ->on('images')->references('id');

            $table->index('role_id', 'user_role_idx');
            $table->foreign('role_id', 'user_role_fk')
                ->on('roles')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
