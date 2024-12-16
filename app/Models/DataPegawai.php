<?php

namespace App\Models;

use App\Models\DataProses;
use Illuminate\Database\Eloquent\Model;

class DataPegawai extends Model
{
    public $guarded = [];

    public function DataProses()
    {
        return $this->hasMany(DataProses::class);
    }
}


