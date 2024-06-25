<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_machine_maintenance extends Model
{
    use HasFactory;
    protected $table = 'cpay_machine_maintenance';
    protected $primaryKey = 'MMAINTENANCE_ID';
}
