

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchercoderedemptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_code_redemption', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_code_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->datetime('redeemed_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->datetime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->datetime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->onUpdate(\DB::raw('CURRENT_TIMESTAMP'));
			$table->index(["voucher_code_id"]);
            $table->index(["recipient_id"]);
			$table->foreign('voucher_code_id')->references('id')->on('voucher_codes')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('recipient_id')->references('id')->on('recipients')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_code_redemption');
    }
}

