<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_url', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site',255)->nullable();
            $table->string('url_list',255)->nullable();
            $table->string('page',255)->index();
            $table->enum('type', ['add','remove']);
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
        Schema::dropIfExists('site_url');
    }
}
