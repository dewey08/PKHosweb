<?php

namespace App\Imports;

use App\Models\Ot_one;
use Maatwebsite\Excel\Concerns\ToModel;

class OtImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Ot_one([
            //
        ]);
    }
}
