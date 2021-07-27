<?php

namespace App\Http\Controllers;

use App\Imports\EraChitaImport;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\eraChita;


class ServiceController extends Controller
{
    public function eraChita() {
        try {
            $values = Excel::toArray(new EraChitaImport, 'forestlj_erachita.xlsx', 'eraChita');
        } catch (\Exception $exception) {
            $values = false;
        }
        if ($values) {
            try{
                foreach ($values[0] as $value) {
                    $product = eraChita::query()->where('value', '=', $value['articul'])
                        ->where('tmplvarid', '=', 32)->first();

                    if ($product) {
                        // price
                        if ($value['price']) {
                            $price = eraChita::query()->where('tmplvarid','=', 16)
                                ->where('contentid', '=', $product->contentid)->first();
                            $price->value = round($value['price']);
                            $price->update();
                        }

                        // count положительный
                        if ($value['count'] || $value['count'] > 0) {
                            $count = eraChita::query()->where('tmplvarid','=', 33)
                                ->where('contentid', '=', $product->contentid)->first();
//                        dd($count);
                            $count->value = round($value['count']);
                            $count->update();
                        }

                        // count 0 или отрицательный
                        if ($value['count'] < 1) {
                            $count = eraChita::query()->where('tmplvarid','=', 33)
                                ->where('contentid', '=', $product->contentid)->first();
                            $count->value = 0;
                            $count->update();
                        }
                    }
                }
                $newName = date("d-m-Y");
                Storage::move('/public/eraChita/forestlj_erachita.xlsx', '/public/eraChita/old/' . $newName . '.xlsx');
            } catch (\Exception $exception) {
                $mail = new MailService();
                $mail->sendMail('eraChita', $exception);
            }
        }
        dd('end');
    }

    public function ortoComfort() {
        try {
            $values = Excel::toArray(new EraChitaImport, 'forestlj_ortocomfort.xlsx', 'ortoComfort');
        } catch (\Exception $exception) {
            $values = false;
        }

        dd($values);
        dd('end');

    }
}
