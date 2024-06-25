<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Lab_order_image extends Model
{
    use HasFactory;

    protected $connection = 'mysql14';
    protected $table = 'lab_order_image';
    protected $primaryKey = 'lab_order_number';
    public $timestamps = false;     
}
