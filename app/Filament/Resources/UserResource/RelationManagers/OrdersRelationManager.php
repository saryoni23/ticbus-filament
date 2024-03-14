<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use function Filament\Support\format_money;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    // public static function shouldRegisterNavigation(): bool
    // {
    //     if(auth()->user()->can('rute'))
    //         return true;
    //     else
    //         return false;
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),

                TextColumn::make('items.harga_total')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   =>  'info',
                        'paid'      =>  'success',
                        'unpaid'    =>  'warning',
                    })
                    // ->label(fn (string $state): string => match ($state) {
                    //     'pending'   =>  'Ditunggu',
                    //     'paid'      =>  'Dibayar',
                    //     'unpaid'    =>  'Belum Dibayar',
                    // })
                    ->sortable()
                    ->searchable(),

                // TextColumn::make('payment_status')
                //     ->sortable()
                //     ->badge()
                //     ->searchable(),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('View Order')
                ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                ->color('info')
                ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
