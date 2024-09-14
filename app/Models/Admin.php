<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'country',
        'email',
        'password',
        'first_name',
        'last_name',
        'store_name',
        'company_legal_name',
        'company_phone_number',
        'full_address',
        'trade_licence',
        'national_id',
        'beneficiary_name',
        'payoneer_email',
        'bank_name',
        'branch_name',
        'account_number',
        'iban_number',
        'swift_code',
        'currency',
        'tax_registration_number',
        'tax_registration_certificate',
    ];
}