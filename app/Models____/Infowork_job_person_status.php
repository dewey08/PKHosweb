<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infowork_job_person_status extends Model
{
    use HasFactory;
    protected $table = 'infowork_job_person_status';
    protected $primaryKey = 'IWJOB_PERSON_STATUS_ID';
}
