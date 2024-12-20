<?php

namespace App\Http\Controllers;

// use App\Models\AmountWord;
use App\Models\ChequeDetails;
use App\Models\payment;
use App\Models\PaymentMode;
use App\Models\ReceiptVoucher;
use App\Models\VoucherCode;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ReceiptVoucherController extends Controller
{
    public function store(Request $request)
    {
        // Validate input fields
        $validated = $request->validate([
            'rv_code' => 'required|exists:voucher_codes,rv_code', // Ensure rv_code exists in voucher_codes table
            'code.*' => 'nullable|string|max:255',
            'description.*' => 'nullable|string|max:255',
            'amount_rs.*' => 'required|numeric|min:0',
            'amount_usd.*' => 'required|numeric|min:0',
            'payment_for.*' => 'nullable|string|max:255', // Validate the Payment For field
            'payment_status' => 'nullable|string',
            'mode_of_payment' => 'nullable|string',
            'cheque_no.*' => 'nullable|string',
            'cheque_date.*' => 'nullable|date',
            'amount.*' => 'nullable|numeric|min:0',
            'bank.*' => 'nullable|string',
        ]);

        // Find the related Voucher Code
        $voucherCode = VoucherCode::where('rv_code', $request->rv_code)->firstOrFail();

        // Loop through the input arrays and create receipt voucher entries
        foreach ($request->code as $index => $code) {
            $receiptVoucher = ReceiptVoucher::create([
                'rv_code' => $voucherCode->id, // Foreign key ID
                'code' => $code ?? null,
                'description' => $request->description[$index] ?? null,
                'amount_rs' => $request->amount_rs[$index] ?? 0,
                'amount_usd' => $request->amount_usd[$index] ?? 0,
            ]);
        }

        $Paymentfor = new payment();
        $Paymentfor->rv_code = $voucherCode->id; // Link to the voucher code
        $Paymentfor->payment_for = $request->payment_for;
        $Paymentfor->save();

        $paymentmodes = new PaymentMode();
        $paymentmodes->rv_code = $voucherCode->id; // Link to the voucher code
        $paymentmodes->payment_status = $request->payment_status;
        $paymentmodes->payment_mode = $request->mode_of_payment;
        $paymentmodes->save();

        if ($request->mode_of_payment == 'Cheque') {
            foreach ($request->cheque_no as $key => $chequeNo) {
                if (!empty($chequeNo)) {
                    ChequeDetails::create([
                        'rv_code' => $voucherCode->id,
                        'cheque_no' => $chequeNo,
                        'cheque_date' => $request->cheque_date[$key],
                        'amount' => $request->amount[$key],
                        'bank' => $request->bank[$key],
                    ]);
                }
            }
        }

        // Redirect back with a success message
        // return redirect()->route('index1_form')->with('success', 'Receipt Voucher created successfully!');
        return redirect()->route('generaterv.pdf', ['rv_code' => $validated['rv_code']]);
    }
    public function generatervPdf($rv_code)
    {
        // Retrieve the Voucher Code record for the given RV Code
        $voucherCode = VoucherCode::where('rv_code', $rv_code)->firstOrFail();

        // Fetch related data
        $receiptVouchers = ReceiptVoucher::where('rv_code', $voucherCode->id)->get();
        $payment = Payment::where('rv_code', $voucherCode->id)->get();
        $paymentMode = PaymentMode::where('rv_code', $voucherCode->id)->get();
        $chequeDetails = ChequeDetails::where('rv_code', $voucherCode->id)->get();

        // Calculate the total amounts for Rs. and USD
        $totalAmountRs = $receiptVouchers->sum('amount_rs');
        $totalAmountUsd = $receiptVouchers->sum('amount_usd');

        // Convert the amounts to words (Rs. and USD)
        $amountInWordsRs = $this->convertToWords($totalAmountRs, 'LKR');  // Assuming 'LKR' for Rs.
        $amountInWordsUsd = $this->convertToWords($totalAmountUsd, 'USD');

        // Prepare data for the PDF
        $data = [
            'voucherCode' => $voucherCode,
            'receiptVouchers' => $receiptVouchers,
            'amountInWordsRs' => $amountInWordsRs,  // Pass Rs. amount in words
            'amountInWordsUsd' => $amountInWordsUsd,  // Pass USD amount in words
            'payment' => $payment,
            'paymentMode' => $paymentMode,
            'chequeDetails' => $chequeDetails,
        ];

        // Load the Blade view and pass the data
        $pdf = FacadePdf::loadView('pdf.receipt_voucher', $data);

        // Return the generated PDF as a downloadable file
        return $pdf->stream('receipt_voucher_' . $rv_code . '.pdf');
    }

    private function convertToWords($number, $currency)
    {
        // Split the number into the integer and decimal parts
        $integerPart = (int)$number;
        $decimalPart = round(($number - $integerPart) * 100); // Get the decimal part (paise or cents)

        // Convert the integer part to words
        $words = $this->numberToWords($integerPart);

        // Handle currency suffix
        if ($currency == 'LKR') {
            $currencyName = 'Rupees';
            $decimalName = 'Paise';
        } elseif ($currency == 'USD') {
            $currencyName = 'Dollars';
            $decimalName = 'Cents';
        }

        // Return the formatted string
        return ucfirst($words) . " $currencyName" . ($decimalPart > 0 ? " and " . $this->numberToWords($decimalPart) . " $decimalName" : "");
    }

    private function numberToWords($num)
    {
        if ($num == 0) {
            return 'Zero';
        }

        $ones = [
            1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen'
        ];

        $tens = [
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        $thousands = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

        // Split the number into groups of 3 digits
        $numStr = strrev((string)$num);
        $numLen = strlen($numStr);
        $chunks = [];
        for ($i = 0; $i < $numLen; $i += 3) {
            $chunks[] = strrev(substr($numStr, $i, 3));
        }

        $words = [];
        foreach ($chunks as $index => $chunk) {
            $chunkNum = (int)$chunk;
            if ($chunkNum == 0) {
                continue;
            }

            $chunkWords = [];
            if ($chunkNum > 99) {
                $hundred = (int)($chunkNum / 100);
                $chunkWords[] = $ones[$hundred] . ' Hundred';
                $chunkNum %= 100;
            }

            if ($chunkNum > 19) {
                $ten = (int)($chunkNum / 10) * 10;
                $chunkWords[] = $tens[$ten];
                $chunkNum %= 10;
            }

            if ($chunkNum > 0) {
                $chunkWords[] = $ones[$chunkNum];
            }

            // Add the corresponding thousand, million, etc., based on the chunk's position
            $words[] = implode(' ', $chunkWords) . ' ' . $thousands[$index];
        }

        // Reverse the word order and return the result
        return implode(' ', array_reverse($words));
    }

}
