<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'draft' => Tab::make('Draft')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'draft')),
            'sent' => Tab::make('Sent')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'sent')),
            'paid' => Tab::make('Paid')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'paid')),
            'overdue' => Tab::make('Overdue')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'overdue')),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn($query) => $query->where('status', 'cancelled')),
        ];
    }

    public function getDefaultActiveTab(): string
    {
        return 'all';
    }
}
