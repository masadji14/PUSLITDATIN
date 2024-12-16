<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataProses extends Model
{
    public $guarded = [];

    public function DataPegawai()
    {
        return $this->belongsTo(DataPegawai::class);
    }
}
