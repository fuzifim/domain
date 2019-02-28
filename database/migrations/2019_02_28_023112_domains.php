<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Domains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain',255)->nullable();
            $table->string('base_64',255)->index();
            $table->string('title',255)->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->string('icon',500)->nullable();
            $table->string('img',500)->nullable();
            $table->string('img_thumb',500)->nullable();
            $table->string('img_small',500)->nullable();
            $table->string('img_xs',500)->nullable();
            $table->string('cache_url',500)->nullable();
            $table->string('cache_path',500)->nullable();
            $table->string('ip',255)->nullable();
            $table->text('dns_record')->nullable();
            $table->text('website')->nullable();
            $table->text('whois')->nullable();
            $table->text('rank')->nullable();
            $table->string('region',255)->nullable();
            $table->integer('craw_replay')->default(0);
            $table->integer('review_number')->default(0);
            $table->longText('report_outlook')->nullable();
            $table->enum('ads', ['pending','active','disable'])->default('pending');
            $table->enum('status', ['pending','active','delete','blacklist'])->default('pending')->index();
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
        Schema::dropIfExists('article');
    }
}
