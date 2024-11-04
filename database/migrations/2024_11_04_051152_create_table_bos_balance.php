<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBosBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bos_balance', function (Blueprint $table) {
            $table->string('accountId',50);
            $table->string('currencyId',50);
            $table->decimal('decAmount', $precision = 30, $scale = 8);
            $table->primary(['accountId','currencyId']);
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
        Schema::dropIfExists('bos_balance');
    }
}
