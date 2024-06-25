<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donateperson extends Model
{
    protected $table = 'donation_person';
    protected $primaryKey = 'DONATE_PERSON_ID';
    public $timestamps = false;
}