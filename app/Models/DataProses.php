<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class DataProses extends Model
{
    public $guarded = [];

    public function DataPegawai()
    {
        return $this->belongsTo(DataPegawai::class, 'data_pegawai_id');
    }
}
