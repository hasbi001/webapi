<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBosHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bos_history', function (Blueprint $table) {
            $table->string('transactionId',50);
            $table->string('accountId',50);
            $table->string('currencyId',50);
            $table->date('dtmTransaction');
            $table->decimal('decAmount', $precision = 30, $scale = 8);
            $table->string('note',255);
            $table->primary(['transactionId','accountId','currencyId']);
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
        Schema::dropIfExists('bos_history');
    }
}
