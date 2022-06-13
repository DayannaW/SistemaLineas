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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('ciudad');
            $table->unsignedBigInteger('cuenta')->nullable();
            $table->unsignedBigInteger('actividad')->nullable();
            $table->date('fecha_requerimiento');
            $table->unsignedBigInteger('numeroLinea')->nullable();
            $table->string('responsable');

            $table->foreign('cuenta')
                    ->references('id')->on('cuentas')
                    ->onDelete('set null');
            
            $table->foreign('actividad')
                    ->references('id')->on('actividades')
                    ->onDelete('set null');

            $table->foreign('numeroLinea')
                    ->references('id')->on('lineas')
                    ->onDelete('set null');

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
        Schema::dropIfExists('usuarios');
    }
};
