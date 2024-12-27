<?php

namespace App\Filament\Exports;

use Barryvdh\DomPDF\PDF;
use App\Models\DataProses;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class DataProsesExporter extends Exporter
{
    protected static ?string $model = DataProses::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('data_pegawai_id')
                ->label('Nama'),
            ExportColumn::make('tanggal_CPNS'),
            ExportColumn::make('tanggal_PNS'),
            ExportColumn::make('pensiun'),
            ExportColumn::make('KGB'),
            ExportColumn::make('KP'),
            ExportColumn::make('tanggal_lahir'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your data proses export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public static function download(array $records): mixed
    {
        $data = collect($records)->map(function ($record) {
            return [
                'ID' => $record->id,
                'Nama' => $record->dataPegawai->nama,
                'Tanggal CPNS' => $record->tanggal_CPNS,
                'Tanggal PNS' => $record->tanggal_PNS,
                'Pensiun' => $record->pensiun,
                'KGB' => $record->KGB,
                'KP' => $record->KP,
                'Tanggal Lahir' => $record->tanggal_lahir,
            ];
        });

        // $pdf = Pdf::loadView('exports.data_proses_pdf', ['data' => $data]);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.data_proses_pdf', ['data' => $data]);

        return $pdf->download('data_proses.pdf');
    }
}
