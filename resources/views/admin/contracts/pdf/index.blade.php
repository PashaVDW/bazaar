<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contract</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.6; }
        h1 { color: #1E3A8A; }
        .section { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Business Contract</h1>

    <div class="section">
        <strong>Company Name:</strong> {{ $business->company_name }}<br>
        <strong>Contact Person:</strong> {{ $business->user->name }}<br>
        <strong>Email:</strong> {{ $business->user->email }}<br>
        <strong>Phone:</strong> {{ $business->phone }}
    </div>

    <div class="section">
        <p>This contract confirms the registration of the above business on the De Bazaar platform.
        The business agrees to the platform terms and conditions, including usage, data handling,
        and availability of rental and auction features.</p>
    </div>

    <div class="section">
        <strong>Date:</strong> {{ now()->format('d-m-Y') }}<br><br>
        ____________________________<br>
        Signature
    </div>
</body>
</html>
