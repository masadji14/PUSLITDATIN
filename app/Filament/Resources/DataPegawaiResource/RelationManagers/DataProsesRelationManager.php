<?php

namespace App\Filament\Resources\DataPegawaiResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataProsesRelationManager extends RelationManager
{
    protected static string $relationship = 'DataProses';
    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('data_pegawai_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_CPNS')
                    ->label('Tanggal CPNS')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_PNS')
                    ->label('Tanggal PNS')
                    ->required(),
                Forms\Components\DatePicker::make('pensiun')
                    ->label('Tanggal Pensiun')
                    ->required(),
                Forms\Components\DatePicker::make('KGB')
                    ->label('Tanggal KGB')
                    ->required(),
                Forms\Components\DatePicker::make('KP')
                    ->label('Tanggal KP')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_ulangtahun')
                    ->label('Tanggal Ulang Tahun')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('data_pegawai_id')
            ->columns([
                Tables\Columns\TextColumn::make('data_pegawai_id'),
                Tables\Columns\TextColumn::make('tanggal_CPNS')
                    ->label('Tanggal CPNS')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_PNS')
                    ->label('Tanggal PNS')
                    ->date(),
                Tables\Columns\TextColumn::make('pensiun')
                    ->label('Pensiun')
                    ->date(),
                Tables\Columns\TextColumn::make('KGB')
                    ->label('KGB')
                    ->date(),
                Tables\Columns\TextColumn::make('KP')
                    ->label('KP')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_ulangtahun')
                    ->label('Tanggal Ulang Tahun')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
