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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('about',120)->nullable();
            $table->string('phone_number',22)->nullable();
            $table->string('company_name',130)->nullable();

            $table->string('service_no',30)->nullable();
            $table->string('ippis_no',30)->nullable();
            $table->string('grade_level',30)->nullable();
            $table->string('step',30)->nullable();
            $table->string('rank',30)->nullable();
            $table->string('service_length',30)->nullable();
            $table->string('retirement_date',30)->nullable();
            $table->string('lga',30)->nullable();
            $table->string('kin_name',30)->nullable();
            $table->string('kin_address',80)->nullable();
            $table->date('dob')->nullable();
            $table->string('salary_account',30)->nullable();
            $table->string('bank',50)->nullable();

            $table->string('category',30)->nullable();
            $table->string('address')->nullable();

            $table->string('state',30)->nullable();
            $table->string('account_manager',50)->nullable();

            $table->string('business_id')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();

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
