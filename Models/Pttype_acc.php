<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Pttype_acc extends Model
{
    use HasFactory;

    protected $connection = 'mysql10';
    protected $table = 'pttype_acc';
    protected $primaryKey = 'pttype_acc_id';
    public $timestamps = false;     
}
