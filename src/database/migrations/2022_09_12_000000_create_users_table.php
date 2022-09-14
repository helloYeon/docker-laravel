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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8mb4_bin';

            $table->increments('id')->comment('user id');
            $table->string('sub')->unique()->comment('sub');
            $table->string('tel')->comment('tel number');
            $table->string('name')->nullable()->comment('user name');
            $table->string('email')->unique()->comment('mail address');
            $table->text('token')->comment('access token');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        DB::statement("ALTER TABLE users COMMENT 'ユーザテーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
