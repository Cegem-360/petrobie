<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('product_id'),
            ImportColumn::make('product_name'),
            ImportColumn::make('urlpicture'),
            ImportColumn::make('barcode'),
            ImportColumn::make('description'),
            ImportColumn::make('stock'),
            ImportColumn::make('price')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Product
    {
        return Product::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'product_id' => $this->data['productid'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
