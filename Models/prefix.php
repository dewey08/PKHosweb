<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    protected $table = 'hrd_prefix';

    public function persons() {
         return $this->hasMany(Person::class,'HR_PREFIX_ID');
     }

}
