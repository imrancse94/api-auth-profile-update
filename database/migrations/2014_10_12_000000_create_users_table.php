<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('user_name',20)->unique()->nullable();
            $table->string('email',50)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('avatar',100)->nullable();
            $table->tinyInteger('user_role')->default(0); // 1 = Admin 2 = User
            $table->tinyInteger('status')->default(0); // 1 = Active 0 = Inactive
            $table->string('unique_key',50)->nullable();
            $table->dateTime('registered_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
