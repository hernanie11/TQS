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
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_active');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('account_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->enum('role', ['admin', 'cashier']);
            $table->json('access_permission');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female']);
            $table->string('birthday');
            $table->string('barangay');
            $table->string('municipality');
            $table->string('province');
            $table->string('email');
            $table->string('mobile_number');
            $table->boolean('is_active');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('set null');  
        });

        Schema::create('earnedpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_id');
            $table->unsignedInteger('member_id');
            $table->string('transaction_no');
            $table->double('amount', 8, 2);
            $table->double('points_earn', 8, 2);
            $table->dateTime('transaction_datetime');
            $table->unsignedInteger('created_by')->nullable();
            $table->string('category');
            $table->boolean('is_cleared');
            $table->dateTime('cleared_datetime')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('member_id')
            ->references('id')
            ->on('members')
            ->onDelete('cascade');
            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('set null');  
        });

        Schema::create('earnings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pointing');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('set null'); 
        });

        Schema::create('earning_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->string('transaction_no');
            $table->double('amount', 8, 2);
            $table->double('points_earn', 8, 2);
            $table->dateTime('transaction_datetime');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('member_id')
            ->references('id')
            ->on('members')
            ->onDelete('cascade');
            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('set null'); 
            
        });

        Schema::create('redeeming_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->double('points_redeemed', 8, 2);
            $table->dateTime('transaction_datetime');
            $table->string('store_code');
            $table->string('store_name');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('member_id')
            ->references('id')
            ->on('members')
            ->onDelete('cascade');
            $table->foreign('created_by')
            ->references('id')
            ->on('users')
            ->onDelete('set null'); 
        });

        Schema::create('clearedpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->double('total_cleared_points', 8, 2);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('member_id')
            ->references('id')
            ->on('members')
            ->onDelete('cascade');
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
