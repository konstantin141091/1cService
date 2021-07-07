<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EraChita extends Model
{
    protected $table = 'modx_site_tmplvar_contentvalues';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'tmplvarid',
        'contentid',
        'value',
    ];
    public $timestamps = false;
}
