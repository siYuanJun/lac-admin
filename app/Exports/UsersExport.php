<?php

namespace App\Exports;

use App\Http\Model\Zusernumber;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Zusernumber::all();
    }
}
