<?php

namespace App\Filament\Exports;

use App\Models\DataPegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Exports\Exporter;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;

class DataPegawaiExporter extends Exporter
{
    protected static ?string $model = DataPegawai::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nip'),
            ExportColumn::make('nama'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('alamat'),
            ExportColumn::make('no_rekening'),
            ExportColumn::make('no_ktp'),
            ExportColumn::make('pendidikan'),
            ExportColumn::make('email'),
            ExportColumn::make('tmt_cpns'),
            ExportColumn::make('tmt_pns'),
            ExportColumn::make('status'),
            ExportColumn::make('pangkat'),
            ExportColumn::make('golongan_jabatan'),
            ExportColumn::make('jenis_kelamin'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your data pegawai export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
    public function exportToPdf(array $data): string
    {
        // Pastikan data diisi
        if (empty($data)) {
            throw new \Exception('Data untuk ekspor kosong.');
        }
        // Nama file PDF
        $filePath = 'exports/data_pegawai.pdf';

        // Simpan data ke file PDF
        PDF::loadView('exports.data_pegawai', ['data' => $data])
            ->setPaper('a4', 'landscape') // Atur ukuran kertas
            ->save(storage_path('app/' . $filePath)); // Simpan ke storage

        return $filePath;
    }

    public function getXlsxHeaderCellStyle(): ?Style
    {
        return (new Style())
            ->setFontBold()
            ->setFontItalic()
            ->setFontSize(14)
            ->setFontName('Consolas')
            ->setFontColor(Color::BLACK)
            ->setBackgroundColor(Color::BLUE)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    }
}
