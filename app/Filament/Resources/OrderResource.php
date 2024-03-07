<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Tiket;

use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Support\Number;
use Illuminate\Support\Str;


use function Filament\Support\format_money;
use function Laravel\Prompts\select;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Tiket Rute')->schema([
                        Section::make([
                            Select::make('user_id')
                                ->required()
                                ->label('Customer')
                                ->searchable()
                                ->preload()
                                ->relationship('user', 'name'),
                            Select::make('payment_status')
                                ->options([
                                    'pending' => 'Pending',
                                    'paid' => 'Dibayar',
                                    'unpaid' => 'Belum Dibayar',
                                ]),
                            ToggleButtons::make('status')
                                ->inline()
                                ->default('unpaid')
                                ->required()
                                ->options([
                                    'pending' => 'Pending',
                                    'paid' => 'Dibayar',
                                    'unpaid' => 'Belum Dibayar',
                                ])->colors([
                                    'pending' => 'info',
                                    'paid' => 'success',
                                    'unpaid' => 'warning',
                                ]),
                            MarkdownEditor::make('notes')
                                ->fileAttachmentsDirectory('order')
                                ->columnSpanFull(),
                        ])->columns(2),

                        Section::make('Pemesana')->schema([
                            Repeater::make('items')
                                ->relationship()
                                ->schema([
                                    Select::make('tiket_id')
                                        ->relationship('tiket', 'name')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state, Set $set) => $set('harga_satuan', Tiket::find($state)?->price ?? 0))
                                        ->afterStateUpdated(fn ($state, Set $set) => $set('harga_total', Tiket::find($state)?->price ?? 0))
                                        ->columnSpan(4),

                                    TextInput::make('jumlah_tiket')
                                        ->numeric()
                                        ->required()
                                        ->default(1)
                                        ->minValue(1)
                                        ->reactive()
                                        ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('harga_total', $state * $get('harga_satuan')))
                                        ->columnSpan(2),

                                    TextInput::make('harga_satuan')
                                        ->numeric()
                                        ->required()
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpan(3),

                                    TextInput::make('harga_total')
                                        ->numeric()
                                        ->required()
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpan(3)
                                ])->columns(12),

                            Placeholder::make('grand_total_placeholder')
                                ->label('Total Harga semua')
                                ->content(function (Get $get, Set $set) {
                                    $total = 0;
                                    if (!$repeaters = $get('items')) {
                                        return $total;
                                    }

                                    foreach ($repeaters as $key => $repeater) {
                                        $total += $get("items.{$key}.harga_total");
                                    }
                                    $set('grand_total', $total);
                                    return 'Rp ' . number_format($total, 2);
                                }),
                                Hidden::make('grand_total')
                                    ->default(0)
                        ]),
                    ]),

                ])->columnSpan(2),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));})
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->searchable(),
                SelectColumn::make('status')
                ->options([
                    'pending'   => 'Pending',
                    'paid'      => 'Dibayar',
                    'unpaid'    => 'Belum Dibayar',
                ]),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
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
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationBadgeColor():string|array|null
    {
        return static::getModel()::count()>10?'danger':'success';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
