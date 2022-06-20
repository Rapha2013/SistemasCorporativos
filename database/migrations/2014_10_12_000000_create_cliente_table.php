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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
        });

        // Insert some stuff
        DB::table('cliente')->insert(
            array(
                'name' => 'João',
                'email' => 'joao123@hotmail.com',
                'phone' => '41997773413',
                'address' => 'Rua Saira Dourada, 1, Curitiba, Paraná',
            )
        );

        // Insert some stuff
        DB::table('cliente')->insert(
            array(
                'name' => 'Bruno',
                'email' => 'bruno123@hotmail.com',
                'phone' => '41999999999',
                'address' => 'Rua Sapoti, 2, Curitiba, Paraná',
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
        Schema::dropIfExists('cliente');
    }
};
