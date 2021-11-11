<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelasiMahasiswaMatakuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa_matakuliah', function (Blueprint $table){
            $table->dropColumn('mahasiswa_id');
            $table->dropColumn('matakuliah_id');
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->unsignedBigInteger('mk_id')->nullable();
            $table->foreign('mhs_id')->references('Nim')->on('mahasiswa');
            $table->foreign('mk_id')->references('id')->on('matakuliah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa_matakuliah', function (Blueprint $table){
            $table->integer('mahasiswa_id');
            $table->integer('matakuliah_id');
            $table->dropForeign(['mhs_id']);
            $table->dropForeign(['mk_id']);
        }); 
    }
}
