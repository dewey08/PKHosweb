<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_set_inventory extends Model
{
    use HasFactory;
    protected $table = 'medical_set_inventory';
    protected $primaryKey = 'SETINVEN_ID';
    
}
