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
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location_file')->nullable();
            $table->string('nomor_berkas')->nullable();
            $table->string('kode_klasifikasi')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('author')->nullable();
            $table->string('offline_location')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
