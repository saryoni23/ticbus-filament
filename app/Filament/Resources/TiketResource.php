<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TiketResource\Pages;
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

use function Filament\Support\format_money;

class TiketResource extends Resource
{
    protected static ?string $model = Tiket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Form $form): Form

    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Tiket Rute')->schema([
                        Section::make([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                    if ($operation !== 'create') {
                                        return;
                                    }
                                    $set('slug', Str::slug($state));
                                }),
                            TextInput::make('slug')
                                ->maxLength(255)
                                ->readonly()
                                ->required()
                                ->dehydrated()
                                ->unique(Tiket::class, 'slug', ignoreRecord: true),
                            MarkdownEditor::make('description')
                                ->fileAttachmentsDirectory('tiket')
                                ->columnSpanFull(),
                        ])->columns(2),
                        FileUpload::make('images')
                            ->multiple()
                            ->directory('tiket')
                            ->maxFiles(5)
                            ->reorderable(),
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Tiket Rute')->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                    ]),
                    Section::make('Jenis Bus')->schema([
                        Select::make('orderItems_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('categori', 'name')
                    ]),
                    Section::make('Rute')->schema([
                        Select::make('rute_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('rute', 'name')
                    ]),
                    Section::make('Status')->schema([
                        Toggle::make('is_active')
                            ->required()
                            ->default('true')
                    ])
                ])->columns(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('categori.name')
                    ->sortable(),
                TextColumn::make('rute.name')
                    ->sortable(),
                TextColumn::make('price')
                ->formatStateUsing(function ($state) {
                    return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));})
                ->sortable(),
                ToggleColumn::make('is_active'),
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
                SelectFilter::make('categori')
                ->relationship('categori','name'),
                SelectFilter::make('rute')
                ->relationship('rute','name')
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
        ];
    }
}
