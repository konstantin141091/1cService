<?php

namespace App\Http\Controllers;

use App\Imports\EraChitaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    public function eraChita() {
        Excel::import(new EraChitaImport, 'test_forest.xlsx', 'eraChita');
        dd('end');

        DB::connection('eraChita')->table('test')->update(['count' => 1]);
        dd('end');
    }
}
