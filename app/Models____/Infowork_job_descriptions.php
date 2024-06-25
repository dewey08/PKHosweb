<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infowork_job_descriptions extends Model
{
    use HasFactory;
    protected $table = 'infowork_job_descriptions';
    protected $primaryKey = 'IWJOB_D_ID';
}
