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
        Schema::create('movement_type', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable(false);
            $table->string('type')->nullable(false);
        });


        // Insert some stuff
        DB::table('movement_type')->insert(
            array(
                'description' => 'Produto',
                'type' => 'S'
            )
        );

        // Insert some stuff
        DB::table('movement_type')->insert(
            array(
                'description' => 'Produto',
                'type' => 'E'
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
        Schema::dropIfExists('movement_type');
    }
};
