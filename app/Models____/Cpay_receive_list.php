<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpay_receive_list extends Model
{
    use HasFactory;
    protected $table = 'cpay_receive_list';
    protected $primaryKey = 'RECEIVE_LIST_ID';
}
