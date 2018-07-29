

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchercodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->date('expired_at');
			$table->datetime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->datetime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->onUpdate(\DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(["code"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_codes');
    }
}

