<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infowork_job_descriptions_set extends Model
{
    use HasFactory;
    protected $table = 'infowork_job_descriptions_set';
    protected $primaryKey = 'IWJOB_D_SET_ID';
}
