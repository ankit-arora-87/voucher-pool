

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('email', 190);
			$table->datetime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->datetime('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->onUpdate(\DB::raw('CURRENT_TIMESTAMP'));
			$table->unique(["email"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipients');
    }
}

