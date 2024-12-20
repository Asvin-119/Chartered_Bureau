<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\VoucherCode;
use Illuminate\Http\Request;

class VoucherCodeController extends Controller
{
    public function create()
    {
        $quotes = Quote::all();

        return view('_temp.temp_form', compact('quotes'));
    }

    public function index_form(){

        $rvcode = VoucherCode::latest()->first();

        return view('_temp.receiptvoucher', compact('rvcode'));
    }

    /**
     * Store the RV and generate an rv_code.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'quote_id' => 'required|exists:quotes,id',
        ]);

        // Create the RV entry
        $rv = VoucherCode::create([ // Use the VoucherCode model to create the entry
            'quote_id' => $request->quote_id,
        ]);

        // Redirect to temp1.create with a success message
        return redirect()->route('index1_form')->with('success', 'Receipt Voucher created successfully with RV Code: ' . $rv->rv_code);
    }
}
