<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\DataPegawai;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class importDataPegawai implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // Periksa salah satu tanggal harus diisi
        $tmtCpns = $this->formatDate($row[9]);
        $tmtPns = $this->formatDate($row[10]);

        if (empty($tmtCpns) && empty($tmtPns)) {
            throw new \Exception("Harus mengisi salah satu antara Tanggal CPNS atau Tanggal PNS.");
        }
        return new DataPegawai([
            'nip' => $row[0],
            'nama' => $row[1],
            'tempat_lahir' => $row[2],
            'tanggal_lahir' => $this->formatDate($row[3]),
            'alamat' => $row[4],
            'no_rekening' => $row[5],
            'no_ktp' => $row[6],
            'pendidikan' => $row[7],
            'email' => $row[8],
            'tmt_cpns' => $tmtCpns,
            'tmt_pns' => $tmtPns,
            'status' => $row[11],
            'pangkat' => $row[12],
            'golongan_jabatan' => $row[13],
            'jenis_kelamin' => $row[14],
        ]);
    }

    private function formatDate(?string $date): ?string
    {
        try {
            return $date ? Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d') : null;
        } catch (\Exception $e) {
            Log::error('Error parsing date: ' . $date . ' - ' . $e->getMessage());
            return null; // Return null if the format is incorrect
        }
    }
}
