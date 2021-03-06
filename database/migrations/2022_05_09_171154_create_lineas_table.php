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
        Schema::create('lineas', function (Blueprint $table) {
            $table->id();
            $table->string('numeroLinea');
            $table->string('operadora');
            $table->unsignedBigInteger('empresaInterna_id')->nullable();
            $table->string('planilla');
            $table->string('plan');
            $table->string('observacion')->nullable();
            $table->Integer('valor');
            $table->string('nombres_usuario')->nullable();
            $table->string('apellidos_usuario')->nullable();
            $table->string('cuenta')->nullable();
            $table->string('actividad')->nullable();
            $table->string('responsable')->nullable();
            $table->string('presupuesto')->nullable();
            $table->string('estado');
            $table->foreign('empresaInterna_id')
                    ->references('id')->on('empresas')
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
        Schema::dropIfExists('lineas');
    }
};
