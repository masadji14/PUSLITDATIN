<?php

namespace App\Models;

use App\Models\DataProses;
use Illuminate\Database\Eloquent\Model;

class DataPegawai extends Model
{
    public $guarded = [];

    protected $casts = [
        'tmt_cpns' => 'date',
        'tmt_pns' => 'date',
    ];

    public function DataProses()
    {
        return $this->hasMany(DataProses::class, 'data_pegawai_id');
    }

    protected static function booted()
    {
        static::saving(function ($pegawai) {
            if (empty($pegawai->tmt_cpns) && empty($pegawai->tmt_pns)) {
                throw new \Exception('Harus mengisi salah satu antara Tanggal CPNS atau Tanggal PNS.');
            }
        });
    }
}