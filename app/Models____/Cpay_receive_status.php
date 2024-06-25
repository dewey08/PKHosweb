<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_receive_status extends Model
{
    use HasFactory;
    protected $table = 'cpay_receive_status';
    protected $primaryKey = 'RECEIVE_STATUS_ID';
}
