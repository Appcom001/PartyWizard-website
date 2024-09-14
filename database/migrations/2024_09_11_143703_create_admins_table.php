<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('store_name');
            $table->string('company_legal_name');
            $table->string('company_phone_number');
            $table->text('full_address');
            $table->string('trade_licence')->nullable();
            $table->string('national_id')->nullable();
            $table->string('beneficiary_name');
            $table->string('payoneer_email')->nullable();
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('account_number');
            $table->string('iban_number');
            $table->string('swift_code');
            $table->string('currency');
            $table->string('tax_registration_number');
            $table->string('tax_registration_certificate')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
