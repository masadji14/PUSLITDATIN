<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\DataProses;
use Filament\Tables\Table;
use App\Models\DataPegawai;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataProsesResource\Pages;
use App\Filament\Resources\DataProsesResource\RelationManagers;

class DataProsesResource extends Resource
{
    protected static ?string $model = DataProses::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('data_pegawai_id')
                    ->label('Nama Pegawai')
                    ->relationship('dataPegawai', 'nama')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn($state, callable $set) => self::updateFormFields($state, $set)),
                Forms\Components\DatePicker::make('tanggal_CPNS')
                    ->label('Tanggal CPNS')
                    ->readOnly(),
                Forms\Components\DatePicker::make('tanggal_PNS')
                    ->label('Tanggal PNS')
                    ->readOnly(),
                Forms\Components\DatePicker::make('pensiun')
                    ->required(),
                Forms\Components\DatePicker::make('KGB')
                    ->label('KGB')
                    ->required(),
                Forms\Components\DatePicker::make('KP')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Ulang Tahun')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dataPegawai.nama')
                    ->label('Nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_CPNS')
                    ->date()
                    ->sortable()
                    ->hidden(fn ($record) => $record?->tmt_pns !== null),
                Tables\Columns\TextColumn::make('tanggal_PNS')
                    ->date()
                    ->sortable()
                    ->hidden(fn ($record) => $record?->tmt_cpns !== null),
                Tables\Columns\TextColumn::make('pensiun')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('KGB')
                    ->label('KGB')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('KP')
                    ->label('KP')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDataProses::route('/'),
            'create' => Pages\CreateDataProses::route('/create'),
            'edit' => Pages\EditDataProses::route('/{record}/edit'),
        ];
    }

    private static function updateFormFields($state, callable $set)
    {
        $pegawai = \App\Models\DataPegawai::find($state);
    
        if ($pegawai) {
            // Set data pegawai
            $set('tanggal_lahir', $pegawai->tanggal_lahir);
            $set('tanggal_CPNS', $pegawai->tmt_cpns);
            $set('tanggal_PNS', $pegawai->tmt_pns);
            
            // Hitung tanggal pensiun
            $tanggal_lahir = $pegawai->tanggal_lahir ? Carbon::parse($pegawai->tanggal_lahir) : null;
            $usia_pensiun = 58;
            $tanggal_pensiun = $tanggal_lahir ? $tanggal_lahir->copy()->addYears($usia_pensiun) : null;
            $set('pensiun', $tanggal_pensiun?->format('Y-m-d'));
    
            // Hitung KGB
            if ($pegawai->tmt_cpns) {
                $tanggal_cpns = Carbon::parse($pegawai->tmt_cpns);
                $tanggal_kgb = $tanggal_cpns->copy()->addYears(2);
                $set('KGB', $tanggal_kgb->format('Y-m-d'));
            } else {
                $set('KGB', null);
            }
    
            // Hitung KP
            if ($pegawai->tmt_pns) {
                $tanggal_pns = Carbon::parse($pegawai->tmt_pns);
                $tanggal_kp = $tanggal_pns->copy()->addYears(4);
                $set('KP', $tanggal_kp->format('Y-m-d'));
            } else {
                $set('KP', null);
            }
        } else {
            // Reset semua nilai jika pegawai tidak ditemukan
            $set('tanggal_lahir', null);
            $set('tanggal_CPNS', null);
            $set('tanggal_PNS', null);
            $set('pensiun', null);
            $set('KGB', null);
            $set('KP', null);
        }
    }    
}
