<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk_account_type extends Model
{
    use HasFactory;
    protected $table = 'risk_account_type';
    protected $primaryKey = 'RISK_ACCOUNTTYPE_ID';
}
