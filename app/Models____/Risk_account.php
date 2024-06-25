<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk_account extends Model
{
    use HasFactory;
    protected $table = 'risk_account';
    protected $primaryKey = 'RISK_ACCOUNT_ID';
}
