<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('sector', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
        });

        // Insert some stuff
        DB::table('sector')->insert(
            array(
                'description' => 'TI',
            )
        );

        // Insert some stuff
        DB::table('sector')->insert(
            array(
                'description' => 'Marketing',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sector');
    }
};
