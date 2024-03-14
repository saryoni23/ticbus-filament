<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RuteResource\Pages;
use App\Models\Rute;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class RuteResource extends Resource
{
    protected static ?string $model = Rute::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        if(auth()->user()->can('rute'))
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
                        Section::make([
                            TextInput::make('tujuan')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull()
                                // ->live(onBlur:true)
                                // ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                ,
                            // TextInput::make('slug')
                            //     ->maxLength(255)
                            //     ->readonly()
                            //     ->required()
                            //     ->unique(Rute::class, 'slug', ignoreRecord:true),
                            TextInput::make('start')
                                ->label('Rute Awal')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('end')
                                ->label('Rute Akhir')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('harga')
                                ->label('Harga Satuan')
                                ->numeric()
                                ->required()
                                ->prefix('Rp'),
                        ])->columns(2),
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('')->schema([
                        TimePicker::make('jam')
                        ->label('Jam Berangkat')
                        ->seconds(false)
                        ->default(now()),
                    Select::make('tiket_id')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('tiket', 'name'),
                    ]),
                    Section::make('Status')->schema([
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
                TextColumn::make('tiket.name')
                    ->sortable(),
                TextColumn::make('tiket.tipebus.name')
                    ->sortable(),
                TextColumn::make('tujuan')
                    ->searchable(),
                TextColumn::make('start')
                    ->label('Rute Awal')
                    ->searchable(),
                TextColumn::make('end')
                    ->label('Rute Akhir')
                    ->searchable(),
                TextColumn::make('jam')
                    ->label('Jam Berangkat')
                    ->dateTime($format = 'H:i'),
                TextColumn::make('harga')
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));})
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_active')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRutes::route('/'),
            'create' => Pages\CreateRute::route('/create'),
            'edit' => Pages\EditRute::route('/{record}/edit'),
            'view' => Pages\ViewRute::route('/{record}/view'),

        ];
    }
}
