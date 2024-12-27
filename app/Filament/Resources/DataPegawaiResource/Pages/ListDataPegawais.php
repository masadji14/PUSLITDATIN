<?php

namespace App\Filament\Resources\DataPegawaiResource\Pages;

use Filament\Actions;
use App\Models\DataPegawai;
use App\Imports\importDataPegawai;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DataPegawaiResource;

class ListDataPegawais extends ListRecords
{
    protected static string $resource = DataPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data = Actions\CreateAction::make();
        return view('imports.data-pegawai-import', compact('data'));
    }

    public $file ='';

    public function save(){
        if($this->file != ''){
            Excel::import(new importDataPegawai(), $this->file);
        }
        // // DataPegawai::create([
        // //     'nip'   => '98123',
        // //     'nama'   => 'Byan',
        // //     'pendidikan'   => 'Sarjana',
        // //     'tempat_lahir'   => 'Jakarta',
        // //     'alamat'   => 'jakarta',
        // //     'no_rekening'   => '13269172',
        // //     'no_ktp'   => '8712363',
        // //     'email'   => 'byan@gmail.com',
        // //     'tmt_cpns'   => '12-05-2022',
        // //     'status'   => 'P3K',
        // //     'pangkat'   => 'P3K',
        // //     'golongan_jabatan'   => 'V',
        // //     'jenis_kelamin'   => 'laki-laki',]);
    }
}
