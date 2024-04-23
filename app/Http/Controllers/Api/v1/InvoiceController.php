<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function payInvoice(Request $request) {
        $invoice = Invoices::findOrFail($request->id);
    }
}
