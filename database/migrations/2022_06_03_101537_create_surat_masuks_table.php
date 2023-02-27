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
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->string('kd_klasifikasi');
            $table->string('no_agenda')->nullable();
            $table->string('indeks_berkas')->nullable();
            $table->string('nomor_surat');
            $table->text('isi_ringkas');
            $table->text('nama_pengirim');
            $table->string('jenis_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('diterima_oleh')->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->string('file_lokasi')->nullable();
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
        Schema::dropIfExists('surat_masuks');
    }
};
