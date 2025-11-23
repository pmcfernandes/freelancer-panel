<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ExpenseController extends Controller
{

    public  function download(int $invoiceId)
    {
        $invoice = Expense::findOrFail($invoiceId);

        if (!$invoice) {
            return redirect()->back()->with('error', 'Expense invoice not found.');
        }

        return response()->download(storage_path('app/private/' . $invoice->attachment));
    }

}
