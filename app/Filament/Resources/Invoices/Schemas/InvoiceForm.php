<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Filament\Enums\InvoiceStatus;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Carbon\Carbon;
use Filament\Support\Enums\Alignment;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(4)
            ->schema([
                Section::make('Invoice Details')
                    ->schema(self::invoiceDetailsSchema())
                    ->columns(3)
                    ->columnSpan(3),
                Section::make('Billing Information')
                    ->schema(self::billingInformationSchema())
                    ->columnSpan(1)
            ]);
    }

    private static function invoiceDetailsSchema(): array
    {
        return [
            TextInput::make('invoice_number')
                ->required(),
            Select::make('customer_id')
                ->relationship('customer', 'name')
                ->required()
                ->createOptionForm(fn(Schema $schema) => CustomerForm::configure($schema))
                ->columnSpanFull(),
            Repeater::make('lines')
                ->relationship()
                ->columns(8)
                ->schema(self::invoiceLinesSchema())
                ->addActionAlignment(Alignment::Start)
                ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                    $data['total'] = (int)$data['quantity'] * (float)$data['unit_price'];
                    return $data;
                })
                ->reactive()
                ->afterStateUpdated(fn (Get $get, Set $set) => self::calculateTotalAmount($get, $set))
                ->columnSpanFull(),
            TextInput::make('discount')
                ->label('Discount (%)')
                ->required()
                ->numeric()
                ->default(0.0)
                ->reactive()
                ->afterStateUpdated(fn (Get $get, Set $set) => self::calculateTotalAmount($get, $set)),
            TextInput::make('shipping_costs')
                ->label('Shipping Costs (EUR)')
                ->required()
                ->numeric()
                ->default(0.0)
                ->reactive()
                ->afterStateUpdated(fn (Get $get, Set $set) => self::calculateTotalAmount($get, $set)),
         TextEntry::make('total_with_vat')
                ->label('Total Amount')
                ->formatStateUsing(fn ($state) => number_format($state, 2) . ' EUR')
                ->getStateUsing(function (Get $get, Set $set) {
                    self::calculateTotalAmount($get, $set);
                    return $get('total_with_vat');
                })->columnSpanFull(),
        ];
    }

    private static function billingInformationSchema() : array
    {
        return [
            DatePicker::make('invoice_date')
                ->required()
                ->default(now()),
            DatePicker::make('due_date')
                ->default(Carbon::now()->addDays(30)),
            TextInput::make('payment_terms')
                ->required()
                ->numeric()
                ->default(0),
            Select::make('status')
                ->options(InvoiceStatus::class)
                ->default('draft')
                ->required(),
        ];
    }

    private static function invoiceLinesSchema(): array
    {
        return [
            TextInput::make('quantity')
                ->hiddenLabel('Qty')
                ->placeholder('Qty')
                ->required()
                ->numeric()
                ->default(1)
                ->columnSpan(1),
            TextInput::make('description')
                ->hiddenLabel('Description')
                ->placeholder('Description')
                ->required()
                ->columnSpan(4),
            TextInput::make('vat')
                ->hiddenLabel('VAT %')
                ->placeholder('VAT %')
                ->required()
                ->numeric()
                ->default(23)
                ->columnSpan(1),
            TextInput::make('unit_price')
                ->hiddenLabel('Unit Price')
                ->placeholder('Unit Price')
                ->required()
                ->numeric()
                ->default(0.0)
                ->columnSpan(2),
            ];
    }


    private static function calculateTotalAmount(Get $get, Set $set): void
    {
        $lines = $get('lines') ?? [];
        $totalAmount = 0.0;
        $discount = (float)$get('discount') ?? 0;
        $shippingCosts = (float)$get('shipping_costs') ?? 0;
        foreach ($lines as $line) {
            $iva = 1 + ((float)$line['vat'] / 100);
            $price_with_discount = (float)$line['unit_price'] * (1 - $discount / 100); // Price after discount
            $price_with_discount = $price_with_discount * $iva; // Apply VAT
            $price_with_discount = $price_with_discount * (int)$line['quantity']; // Multiply by quantity
            $totalAmount += $price_with_discount;
        }

        $totalAmount += $shippingCosts;
        $set('total_with_vat',  $totalAmount);
    }
}
