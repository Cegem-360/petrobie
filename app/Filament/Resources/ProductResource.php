<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\ViewProduct;
use App\Models\Product;
use Faker\Provider\ar_EG\Text;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Termékek';

    public static function form(Form $form): Form
    {
        //$fillable = ['productid', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description'];
        return $form
            ->schema([
                TextInput::make('product_id')
                    ->required(),
                TextInput::make('product_name'),
                TextInput::make('stock')
                    ->default(0),
                TextInput::make('price')
                    ->numeric()
                    ->default(0)
                    ->prefix('HUF'),
                TextInput::make('urlpicture')
                    ->url(),
                TextInput::make('barcode'),
                TextInput::make('description'),
                TextInput::make('sku'),
                TextInput::make('factory'),
                TextInput::make('color'),
                TextInput::make('size'),
                TextInput::make('ability'),
                TextInput::make('tag'),
                TextInput::make('source'),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id')
                    ->searchable(),
                TextColumn::make('product_name')
                    ->searchable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('Ft.')
                    ->sortable(),
                TextColumn::make('sku'),
                TextColumn::make('source')->sortable(),
                TextColumn::make('factory')->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('color')->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('size')->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ability')->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tag')->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('urlpicture')
                    ->url(null)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('barcode')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                    ->sortable()
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
            ->filters([])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])->headerActions([
                ImportAction::make()
                    ->importer(ProductImporter::class),
            ])->paginated([10, 25, 50, 100,200])
            ;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
