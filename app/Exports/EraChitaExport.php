<?php

namespace App\Exports;

use App\Models\eraChita;
use Maatwebsite\Excel\Concerns\FromCollection;

class EraChitaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return eraChita::all();
    }
}
