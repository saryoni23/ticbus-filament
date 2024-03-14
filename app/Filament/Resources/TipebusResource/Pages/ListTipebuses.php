<?php

namespace App\Filament\Resources\TipebusResource\Pages;

use App\Filament\Resources\TipebusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipebuses extends ListRecords
{
    protected static string $resource = TipebusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
