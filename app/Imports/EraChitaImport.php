<?php

namespace App\Imports;

use App\Models\eraChita;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;


class EraChitaImport implements WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue,
    WithValidation, SkipsEmptyRows
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return null;
    }

    // определения количества вставки
    public function batchSize(): int
    {
        return 100;
    }
    // определения количества строк для чтения
    public function chunkSize(): int
    {
        return 100;
    }
    public function rules(): array
    {
        return [
            'articul' => 'required',
            'price' => 'required',
            'count' => 'required'
        ];
    }
}
