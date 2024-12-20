<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 13px;
        }
        #invoice {
            max-width: 555px; /* A4 width - margins */
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #fff;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container" id="invoice">
        <header>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('dist/images/logos/logo.ico') }}" class="dark-logo img1 pb-2" alt="Company Logo">
                    <div class="border text-center" style="width: 60%">
                        <span class="fw-bold pe-2">No :</span>QUT/002
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="text-right">Quotation</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="p-1 text-center" style="background: #00007c; color: #fff; border: 1px solid rgb(112, 112, 112);">CLIENT DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-1" style="background: #e3e3e9; font-weight: bold; border: 1px solid rgb(112, 112, 112);">Date</td>
                                <td class="p-1" style="border: 1px solid rgb(112, 112, 112);">January 1, 2021</td>
                            </tr>
                            <tr>
                                <td class="p-1" style="background: #e3e3e9; font-weight: bold; border: 1px solid rgb(112, 112, 112);">Passenger Name</td>
                                <td class="p-1" style="border: 1px solid rgb(112, 112, 112);">John Doe</td>
                            </tr>
                            <tr>
                                <td class="p-1" style="background: #e3e3e9; font-weight: bold; border: 1px solid rgb(112, 112, 112);">Contact Email</td>
                                <td class="p-1" style="border: 1px solid rgb(112, 112, 112);">john.doe@example.com</td>
                            </tr>
                            <tr>
                                <td class="p-1" style="background: #e3e3e9; font-weight: bold; border: 1px solid rgb(112, 112, 112);">Contact No</td>
                                <td class="p-1" style="border: 1px solid rgb(112, 112, 112);">+1 123 456 7890</td>
                            </tr>
                            <tr>
                                <td class="p-1" style="background: #e3e3e9; font-weight: bold; border: 1px solid rgb(112, 112, 112);">Tour Consultant</td>
                                <td class="p-1" style="border: 1px solid rgb(112, 112, 112);">Consultant Name</td>
                            </tr>
                            <tr>
                                <td class="p-1" style="background: #e3e3e9; font-weight: bold; border: 1px solid rgb(112, 112, 112);">Source / Agent</td>
                                <td class="p-1" style="border: 1px solid rgb(112, 112, 112);">Agent Name</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </header>
    </div>

    <footer>
        <hr style="border: 1px solid rgb(112, 112, 112); width: 66%;">
        <div class="container">
            <!-- Footer content -->
        </div>
    </footer>

    <div class="text-center mt-4">
        <button id="downloadPDF" class="btn btn-primary">Download PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('downloadPDF').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const invoice = document.getElementById('invoice');

            // Generate PDF with A4 size
            const pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'pt',
                format: 'a4'
            });

            pdf.html(invoice, {
                callback: (doc) => {
                    doc.save('invoice.pdf'); // Save with a filename
                },
                x: 20,
                y: 20,
                width: 555 // Adjust width to fit within A4 dimensions
            });
        });
    </script>
</body>
</html>
