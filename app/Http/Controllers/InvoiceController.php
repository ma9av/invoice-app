<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Remove the authentication check
        // Check if the user is authenticated
        // if (!auth()->check()) {
        //     return redirect()->route('login')->with('error', 'You must be logged in to post an invoice.');
        // }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'invoice_number' => 'required|unique:invoices|string|max:50',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'po_number' => 'nullable|string|max:50',
            'bill_to_name' => 'required|string|max:255',
            'bill_to_address' => 'required|string',
            'ship_to_name' => 'required|string|max:255',
            'ship_to_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Handle company logo upload
        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company-logos', 'public');
        }
        

        // dd(storage_path('app/public/'.$logoPath));
        // Create invoice record with items as JSON
        $invoice = Invoice::create([
            // 'user_id' => Auth::user()->id,
            'company_name' => $validated['company_name'],
            'company_logo' => Storage::url('app/public/'.$logoPath),
            'invoice_number' => $validated['invoice_number'],
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'],
            'po_number' => $validated['po_number'],
            'bill_to_name' => $validated['bill_to_name'],
            'bill_to_address' => $validated['bill_to_address'],
            'ship_to_name' => $validated['ship_to_name'],
            'ship_to_address' => $validated['ship_to_address'],
            'items' => json_encode($validated['items']),
            'subtotal' => $validated['subtotal'],
            'discount_rate' => $validated['discount_rate'],
            'discount_amount' => $validated['discount_amount'],
            'tax_rate' => $validated['tax_rate'],
            'tax_amount' => $validated['tax_amount'],
            'total' => $validated['total'],
            'notes' => $validated['notes'],
        ]);

        // dd( asset(Storage::url($logoPath)));

        // Prepare data for PDF
        $pdfData = [
            'company_logo' => $logoPath ? asset(Storage::url($logoPath)) : null,
            'company_name' => $invoice->company_name,
            'invoice_number' => $invoice->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'po_number' => $invoice->po_number,
            'bill_to_name' => $invoice->bill_to_name,
            'bill_to_address' => $invoice->bill_to_address,
            'ship_to_name' => $invoice->ship_to_name,
            'ship_to_address' => $invoice->ship_to_address,
            'items' => json_decode($invoice->items, true),
            'subtotal' => $invoice->subtotal,
            'discount_rate' => $invoice->discount_rate,
            'discount_amount' => $invoice->discount_amount,
            'tax_rate' => $invoice->tax_rate,
            'tax_amount' => $invoice->tax_amount,
            'total' => $invoice->total,
            'notes' => $invoice->notes,
        ];

        // Generate PDF
        $pdf = SnappyPdf::loadView('invoice_pdf', $pdfData);
        
        // Return the PDF for download
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
