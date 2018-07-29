

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchercodeassignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_code_assignment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_code_id')->unsigned();
            $table->integer('offer_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->integer('no_of_usage')->unsigned();
			$table->datetime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->datetime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->onUpdate(\DB::raw('CURRENT_TIMESTAMP'));
			$table->unique(["voucher_code_id", "recipient_id"]);
            $table->index(["voucher_code_id"]);
            $table->index(["offer_id"]);
            $table->index(["recipient_id"]);
			$table->foreign('voucher_code_id')->references('id')->on('voucher_codes')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('voucher_code_assignment');
    }
}

