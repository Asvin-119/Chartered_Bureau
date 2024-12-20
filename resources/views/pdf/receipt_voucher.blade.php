<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice with Icons</title>

    <!-- Inline CSS for dompdf compatibility -->
    <style>
        /* General Body Styling */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            font-size: 13px;
        }

        body::before {
            content: "Chartered Bureau";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg); /* Center and rotate */
            font-size: 120px;
            color: rgba(0, 0, 0, 0.1); /* Semi-transparent */
            z-index: -1; /* Ensures it stays behind the content */
            white-space: nowrap;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse; /* Ensures borders don't double up */
        }

        .th, .td {
            border: 1px solid #808080; /* Adds border to both columns and rows */
            padding: 5px; /* Adds spacing inside table cells */
            text-align: left; /* Aligns text to the left */
        }

        /* Styling for the logo */
        .invoice-header img {
            max-width: 150px;
            height: auto;
        }

        .invoice-header td {
            padding: 10px;
        }

        .invoice-header td.right {
            text-align: right;
        }

        .invoice-header td.left {
            text-align: left;
        }

        .invoice-header td.center {
            text-align: center;
        }

        /* Footer Styling */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 0;
            border-top: 1px solid #000;
            font-size: 10px;
        }

        footer table {
            width: 100%;
        }

        footer td {
            padding: 0;
        }
        img{
            padding: 0 0 0;
            /* margin: 0 5px 50px; */
            width: 500px;
        }

        .img {
            padding: 0 0 0;
            margin: 0 5px 20px;
            width: 16px;
        }


    </style>
</head>

<body>
    <!-- Invoice Container -->
    <div class="container-fluid">
        <header>
            <table class="invoice-header">
                <tr>
                    <td class="left" style="width: 50%;">
                        <!-- Use Laravel's asset() helper to load public assets -->
                        <img src="dist/images/logos/logo.png" class="dark-logo img1 pb-2" alt=""><br>
                        <div style="padding-top: 20px"><input type="text"  name="" id="" value="No : {{ $voucherCode->rv_code }}" readonly></div>

                    </td>
                    <td class="right" style="width: 50%;">
                        <table>
                            <tr>
                                <td class="td" colspan="2" style="background: #00007C; color: #fff; text-align: center; padding: 5px;">CLIENT DETAILS</td>
                            </tr>
                            <tr>
                                <td class="td" style="background: #DCDCDC; color: #000; text-align: left; padding: 5px; font-weight: bold;">Date:</td>
                                <td class="td" style="text-align: left; padding: 5px;">{{ now()->format('Y/m/d') }}</td>
                            </tr>
                            <tr>
                                <td class="td" style="background: #DCDCDC; color: #000; text-align: left; padding: 5px; font-weight: bold;">Passenger Name:</td>
                                <td class="td" style="text-align: left; padding: 5px;"></td>
                            </tr>
                            <tr>
                                <td class="td" style="background: #DCDCDC; color: #000; text-align: left; padding: 5px; font-weight: bold;">Contact Email:</td>
                                <td class="td" style="text-align: left; padding: 5px;"></td>
                            </tr>
                            <tr>
                                <td class="td" style="background: #DCDCDC; color: #000; text-align: left; padding: 5px; font-weight: bold;">Contact No:</td>
                                <td class="td" style="text-align: left; padding: 5px;"></td>
                            </tr>
                            <tr>
                                <td class="td" style="background: #DCDCDC; color: #000; text-align: left; padding: 5px; font-weight: bold;">Tour Consultant</td>
                                <td class="td" style="text-align: left; padding: 5px;"></td>
                            </tr>
                            <tr>
                                <td class="td" style="background: #DCDCDC; color: #000; text-align: left; padding: 5px; font-weight: bold;">Source / Agent</td>
                                <td class="td" style="text-align: left; padding: 5px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </header>

        <!-- Invoice Items -->
        <table style="padding-top: 20px;">
            <tr>
                <th class="th" style="background: #00007C; color: #fff; text-align: center; padding: 5px; width: 7%;">N0</th>
                <th class="th" style="background: #00007C; color: #fff; text-align: center; padding: 5px; width: 15%;">Code</th>
                <th class="th" style="background: #00007C; color: #fff; text-align: center; padding: 5px; width: 48%;">Description</th>
                <th class="th" style="background: #00007C; color: #fff; text-align: center; padding: 5px; width: 15%;">Amount (Rs.)</th>
                <th class="th" style="background: #00007C; color: #fff; text-align: center; padding: 5px; width: 15%;">Amount ($)</th>
            </tr>
            @foreach ($receiptVouchers as $voucher)
            <tr>
                <td class="td" style="padding: 5px; font-weight: 100;"></td>
                <td class="td" style="padding: 5px;">{{ $voucher->code }}</td>
                <td class="td" style="padding: 5px; text-align: left;">{{ $voucher->description }}</td>
                <td class="td" style="padding: 5px; text-align: right;">{{ $voucher->amount_rs }}</td>
                <td class="td" style="padding: 5px; text-align: right;">{{ $voucher->amount_usd }}</td>
            </tr>
            @endforeach
        </table>

        <table style="padding-top: 0">
            <tr>
                <td class="td" style="padding: 5px; text-align: left; background: #f0e8a6; width: 22%;">Amount in Word ( Rs. )</td>
                <td class="td" colspan="4" style="padding: 5px; background: #f0e8a6; width: 77%;">{{ $amountInWordsRs }}</td>
            </tr>
            <tr>
                <td class="td" style="padding: 5px; text-align: left; background: #f0e8a6; width: 22%;">Amount in Word ( $ )</td>
                <td class="td" colspan="4" style="padding: 5px; background: #f0e8a6; width: 77%;">{{ $amountInWordsUsd }}</td>
            </tr>
        </table>

        <table style="padding-top: 0">
            <tr>
                <td colspan="5" style="padding: 5px; text-align: center; background: #00007C; color: #fff;">The Payment For</td>
            </tr>

            @if ($payment->isNotEmpty())
            @foreach ($payment as $item)
                <tr>
                    <td colspan="5" class="td" style="padding: 0; margin: o; text-align: left;">
                        <table>
                            <tr>
                                <td style="width: 25%">
                                    <ul style="padding: 5px; margin: 10px; line-height: 1.2;">
                                        <li>{{ $item->payment_for[0] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[4] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[8] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[12] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[16] ?? 'N/A' }}</li>
                                    </ul>
                                </td>
                                <td style="width: 25%">
                                    <ul style="padding: 5px; margin: 10px; line-height: 1.2;">
                                        <li>{{ $item->payment_for[1] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[5] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[9] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[13] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[17] ?? 'N/A' }}</li>
                                    </ul>
                                </td>
                                <td style="width: 25%">
                                    <ul style="padding: 5px; margin: 10px; line-height: 1.2;">
                                        <li>{{ $item->payment_for[2] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[6] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[10] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[14] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[18] ?? 'N/A' }}</li>
                                    </ul>
                                </td>
                                <td style="width: 25%">
                                    <ul style="padding: 5px; margin: 10px; line-height: 1.2;">
                                        <li>{{ $item->payment_for[3] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[7] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[11] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[15] ?? 'N/A' }}</li>
                                        <li>{{ $item->payment_for[19] ?? 'N/A' }}</li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="3" class="td" style="padding: 5px; text-align: left;">No payments available</td>
                </tr>
            @endif
        </table>

        <table style="padding-top: 0; width: 100%;">
            <tr>
                <td style="padding: 5px; text-align: center; background: #00007C; color: #fff;">Payment Status</td>
            </tr>
            @foreach ($paymentMode as $status )
            <tr>
                <td class="td" style="padding: 5px; text-align: left; width: 40%;">{{ $status->payment_status }}</td>
            </tr>
            @endforeach

            <tr>
                <td style="padding: 5px; text-align: center; background: #00007C; color: #fff;">Mode of Payment</td>
            </tr>
            @foreach ($paymentMode as $status )
            <tr>
                <td class="td" style="padding: 5px; text-align: left; width: 40%;">{{ $status->payment_mode }}</td>
            </tr>
            @endforeach
        </table>

        <table style="padding-top: 0; width: 100%;">
            <tr>
                <td colspan="4" style="padding: 5px; text-align: center; background: #00007C; color: #fff;">Cheque Details</td>
            </tr>
            @foreach ($chequeDetails as $cheque )
            <tr>
                <td class="td" style="padding: 5px; text-align: left; width: 25%;">{{ $cheque->cheque_no }}</td>
                <td class="td" style="padding: 5px; text-align: left; width: 25%;">{{ $cheque->cheque_date }}</td>
                <td class="td" style="padding: 5px; text-align: left; width: 25%;">{{ $cheque->amount }}</td>
                <td class="td" style="padding: 5px; text-align: left; width: 25%;">{{ $cheque->bank }}</td>
            </tr>
            @endforeach
        </table>

        <table style="padding-top: 0; width: 100%;">
            <tr>
                <th colspan="3" style="padding: 5px; text-align: center; background: #00007C; color: #fff;">Payment Receipt Confirmation</th>
            </tr>
            <tr>
                <td class="td" style="padding: 5px; text-align: center; width: 33%; background: #DCDCDC; line-height: 1.2;">
                    <span><strong>Prepared</strong></span><br>
                    <span>( Received By )</span><br>
                </td>
                <td class="td" style="padding: 5px; text-align: center; width: 33%; background: #DCDCDC; line-height: 1.2;">
                    <span><strong>Approved</strong></span><br>
                    <span>( Accountant )</span><br>
                </td>
                <td class="td" style="padding: 5px; text-align: center; width: 33%; background: #DCDCDC; line-height: 1.2;">
                    <span><strong>Client</strong></span><br>
                    <span>( Passenger or Payee )</span><br>
                </td>
            </tr>
            <tr>
                <td class="td" style="padding: 40px"></td>
                <td class="td" style="padding: 40px"></td>
                <td class="td" style="padding: 40px"></td>
            </tr>
        </table>
    </div>

    <!-- Footer Content -->
    <footer>
        <table>
            <tr>
                <td>
                    <table style="padding: 5px;">
                        <tr>
                            <td rowspan="2" style="padding: 2px;"><img src="dist/images/icon/icon-1.png" class="img" alt=""></td>
                            <td style="padding: 2px; font-size: 11px;"><strong>Website</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; color: #404040;">
                                <span>charteredbureau.lk</span><br>
                                <span style="visibility: hidden;">Hi</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="right">
                    <table style="padding: 5px;">
                        <tr>
                            <td rowspan="2" style="padding: 2px;"><img src="dist/images/icon/icon-2.png" class="img" alt=""></td>
                            <td style="padding: 2px; font-size: 10px;"><strong>Email</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; color: #404040;">
                                <span>info@charteredbureau.lk</span><br>
                                <span style="visibility: hidden;">Hi</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="padding: 5px;">
                        <tr>
                            <td rowspan="2" style="padding: 2px;"><img src="dist/images/icon/icon-3.png" class="img" alt=""></td>
                            <td style="padding: 2px; font-size: 10px;"><strong>Phone & WhatsApp</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; color: #404040;">
                                <span>+94 67 205 6455</span><br>
                                <span>+94 75 177 1446</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="right">
                    <table style="padding: 5px;">
                        <tr>
                            <td rowspan="2" style="padding: 2px;"><img src="dist/images/icon/icon-4.png" class="img" alt=""></td>
                            <td style="padding: 2px; font-size: 10px;"><strong>Address</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 2px; color: #404040;">
                                <span>111 C/1, Main Street,</span><br>
                                <span>Maruthamunai 02,, Sri Lanka.</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </footer>
</body>

</html>
