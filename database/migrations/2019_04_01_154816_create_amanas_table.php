<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amanas', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('env', ['dev', 'stg', 'prod']);
            $table->string('app_file_name');
            $table->string('plist_file_name')->nullable();
            $table->string('version');
            $table->string('build');
            $table->tinyInteger('is_latest_version')->default(0)->comment('0: old version, 1: is latest version');
            $table->enum('device_type', ['android', 'ios']);

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
        Schema::drop('amanas');
    }
}
