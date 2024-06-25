<?php

namespace App\Exports;

use App\Models\Refer_cross;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RefercrossExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Refer_cross::getallRefercross());
        // return Refer_cross::all();
    }
    public function headings():array{
        return [
            'vn','an','hn','cid','vstdate','vsttime','ptname','pttype','hospcode','hospmain','pdx','dx0','dx1','income','refer','Total'      
        ];
    }
}
