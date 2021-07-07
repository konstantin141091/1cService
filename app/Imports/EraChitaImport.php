<?php

namespace App\Imports;

use App\Models\EraChita;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Validators\Failure;

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class EraChitaImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue,
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
        $object = EraChita::query()->where('tmplvarid', '=', 32)
            ->where('value', '=', $row['articul'])->get();

        if ($row['price']) {
            DB::connection('eraChita')->table('modx_site_tmplvar_contentvalues')
                ->where('id', $object->contentid)->where('tmplvarid', 16)->update(['value' => $row['price']]);
        }

        if ($row['count']) {
            DB::connection('eraChita')->table('modx_site_tmplvar_contentvalues')
                ->where('id', $object->contentid)->where('tmplvarid', 33)->update(['value' => $row['count']]);
        }

        return null;
//        return new EraChita([
//            //
//        ]);
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
