<?php

namespace App\Imports;

use App\Models\Visit_pttype_import;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ImportVisit_pttype_import implements ToModel,WithHeadingRow
{ 
    public function model(array $row)
    {
        return new Visit_pttype_import([
            // 'visit_pttype_import_id'           => $row['visit_pttype_import_id'],
            'hcode'           => $row['hcode'],
            'hosname'         => $row['hosname'],
            'cid'             => $row['cid' ],
            'fullname'        => $row['fullname' ],
            'birthday'        => $row['birthday'],
            'homtel'          => $row['homtel'],
            'mainpttype'      => $row['mainpttype'],
            'subpttype'       => $row['subpttype'],
            'repcode'         => $row['repcode'],
            'claimcode'       => $row['claimcode'],
            'claimtype'       => $row['claimtype'],
            'servicerep'      => $row['servicerep'],
            'servicename'     => $row['servicename'],
            'hncode'          => $row['hncode' ],
            'ancode'          => $row['ancode'],
            'vstdate'         => $row['vstdate'],
            'regdate'         => $row['regdate'],
            'status'          => $row['status'],
            'repauthen'       => $row['repauthen'],
            'authentication'  => $row['authentication'],
            'staffservice'    => $row['staffservice'],
            'dateeditauthen'  => $row['dateeditauthen'],
            'nameeditauthen'  => $row['nameeditauthen'],
            'comment'         => $row['comment']
        ]);
    }
}
 