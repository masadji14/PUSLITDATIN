<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataPegawai;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rules\Enum;
use Filament\Support\Enums\FontFamily;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\DataPegawaiExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataPegawaiResource\Pages;
use App\Filament\Resources\DataPegawaiResource\RelationManagers;
use Filament\Tables\Actions\ExportBulkAction;

class DataPegawaiResource extends Resource
{
    protected static ?string $model = DataPegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nip')
                    ->label('NIP')
                    ->numeric()
                    ->required(),
                TextInput::make('nama')
                    ->label('Nama')
                    ->required(),
                TextInput::make('tempat_lahir')
                    ->required(),
                DatePicker::make('tanggal_lahir')
                    ->required(),
                Textarea::make('alamat')
                    ->required(),
                TextInput::make('no_rekening')
                    ->numeric()
                    ->required(),
                TextInput::make('no_ktp')
                    ->numeric()
                    ->required(),
                TextInput::make('pendidikan')
                    ->required(),
                TextInput::make('email')
                    ->required(),
                DatePicker::make('tmt_cpns')
                    ->required(),
                DatePicker::make('tmt_pns')
                    ->required(),
                Select::make('status')
                    ->options([
                        'polri' => 'POLRI',
                        'pns' => 'PNS',
                        'p3k' => 'P3K',
                        'ppnpn' => 'PPNPN',
                    ])
                    ->required(),
                TextInput::make('pangkat')
                    ->required(),
                TextInput::make('golongan_jabatan')
                    ->required(),
                Select::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),
                TextColumn::make('nama')
                    ->searchable()
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),
                TextColumn::make('pendidikan')
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),
                TextColumn::make('email')
                    ->fontFamily(FontFamily::Mono)
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->icon('heroicon-o-envelope')
                    ->sortable(),
                TextColumn::make('status')
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),
                TextColumn::make('golongan_jabatan')
                    ->fontFamily(FontFamily::Mono)
                    ->label('Golongan')
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->fontFamily(FontFamily::Mono)
                    ->sortable(),
            ])
            ->filters([
                Filter::make('nama')
                    ->query(
                        fn(Builder $query, array $data): Builder => $query
                            ->when(
                                $data['nama'],
                                fn(Builder $query, $nama): Builder => $query->where('nama', 'like', "%{$nama}%")
                            )
                    )
                    ->form([
                        TextInput::make('nama')->label('Nama'),
                    ]),
                Filter::make('tanggal')
                    ->query(
                        fn(Builder $query, array $data): Builder => $query
                            ->when(
                                $data['tanggal_awal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_lahir', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_akhir'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_lahir', '<=', $date),
                            )
                    )
                    ->form([
                        DatePicker::make('tanggal_awal')
                            ->label('Tanggal Awal')
                            ->columnSpan(2),
                        DatePicker::make('tanggal_akhir')
                            ->label('Tanggal Akhir')
                            ->columnSpan(2),
                    ])->columnSpan(1),
                Filter::make('status')
                    ->query(
                        fn(Builder $query, array $data): Builder => $query
                            ->when(
                                $data['status'],
                                fn(Builder $query, $status): Builder => $query->where('status', $status)
                            )
                    )
                    ->form([
                        Select::make('status')
                            ->options([
                                'Polri' => 'Polri',
                                'PNS' => 'PNS',
                                'P3K' => 'P3K',
                                'PPNPN' => 'PPNPN',
                            ])
                            ->label('Status')
                            ->columnspan(2),
                    ])->columnSpan(1),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make()
                ->icon('heroicon-o-pencil-square')
                ->label(''),
                Tables\Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()->exporter(DataPegawaiExporter::class),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()->exporter(DataPegawaiExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPegawais::route('/'),
            'create' => Pages\CreateDataPegawai::route('/create'),
            'edit' => Pages\EditDataPegawai::route('/{record}/edit'),
        ];
    }
}
