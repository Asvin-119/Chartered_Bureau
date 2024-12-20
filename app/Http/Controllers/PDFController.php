<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'quote_id' => 'AHG/QUO-1234',
            'details' => [
                ['description' => 'Ticket Booking', 'qty' => 2, 'rate' => 500, 'amount' => 1000],
                ['description' => 'Hotel Stay', 'qty' => 3, 'rate' => 700, 'amount' => 2100],
            ],
            'total' => 3100
        ];

        $pdf = Pdf::loadView('pdf.service_details', $data);

        return $pdf->download('service_details.pdf');
    }
}
