<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TiketResource\Pages;
use App\Models\Rute;
use App\Models\Tiket;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\ImageColumn;


use function Filament\Support\format_money;

class TiketResource extends Resource
{
    protected static ?string $model = Tiket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';

    public static function shouldRegisterNavigation(): bool
    {
        if(auth()->user()->can('tiket'))
            return true;
        else
            return false;
    }


    public static function form(Form $form): Form

    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Tiket Rute')->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                    if ($operation !== 'create') {
                                        return;
                                    }
                                    $set('kode', Str::slug($state));
                                }),
                            TextInput::make('kode')
                                ->maxLength(255)
                                ->readonly()
                                ->required()
                                ->dehydrated()
                                ->unique(Tiket::class, 'kode', ignoreRecord: true),
                            Select::make('tipebus_id')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->relationship('tipebus', 'name'),
                            FileUpload::make('images')
                                ->directory('tiket')
                                ->columnSpanFull(),
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('jumlah_tiket')
                            ->required()
                            ->numeric(),
                        Toggle::make('is_active')
                            ->required()
                            ->default('true')
                    ])
                ])->columnSpan(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('tipebus.name')
                    ->sortable(),
                TextColumn::make('jumlah_tiket'),
                ToggleColumn::make('is_active'),
                ImageColumn::make('images')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('tipebus')
                ->relationship('tipebus','name'),
                SelectFilter::make('rute')
                ->relationship('rute','tujuan')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTikets::route('/'),
            'create' => Pages\CreateTiket::route('/create'),
            'edit' => Pages\EditTiket::route('/{record}/edit'),
            'view' => Pages\ViewTiket::route('/{record}/view'),

        ];
    }
}
