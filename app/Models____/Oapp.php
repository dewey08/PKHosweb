<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;

class Oapp extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'oapp';
    protected $primaryKey = 'oapp_id';
    public $timestamps = false;
}
