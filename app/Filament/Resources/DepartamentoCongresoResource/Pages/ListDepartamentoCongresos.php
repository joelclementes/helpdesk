<?php

namespace App\Filament\Resources\DepartamentoCongresoResource\Pages;

use App\Filament\Resources\DepartamentoCongresoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartamentoCongresos extends ListRecords
{
    protected static string $resource = DepartamentoCongresoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
