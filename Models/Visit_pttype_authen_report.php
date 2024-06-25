<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
class Visit_pttype_authen_report extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'visit_pttype_authen_report';
    protected $primaryKey = 'rep_authen_id';
    protected $fillable = [
        'transId',
        'hmain',
        'hname',
        'personalId',
        'patientName',
        'addrNo',
        'moo',
        'moonanName',
        'tumbonName',
        'amphurName',
        'changwatName',
        'birthdate',
        'tel',
        'mainInscl',
        'mainInsclName',
        'subInscl',
        'subInsclName',
        'claimStatus',
        'patientType',
        'claimCode',
        'claimType',
        'claimTypeName',
        'hnCode',
        'claimDate',
        'claimTime',
        'sourceChannel',
        'claimAuthen',
        'mainInsclWithName',
        'created_at',
        'updated_at',
        'date_data'
    ];
    public $timestamps = false;     
}
