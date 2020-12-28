<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('name');
            $table->integer('mssv')->unique();
            $table->string('image')->nullable();
            $table->string('qq');
            $table->integer('sdt');
            $table->bigInteger('vien_id')->unsigned();
            $table->foreign('vien_id')->references('id')->on('viens');
            $table->bigInteger('gt_id')->unsigned();
            $table->foreign('gt_id')->references('id')->on('gts');
            $table->bigInteger('khoa_id')->unsigned();
            $table->foreign('khoa_id')->references('id')->on('khoas');
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
        Schema::dropIfExists('profiles');
    }
}
