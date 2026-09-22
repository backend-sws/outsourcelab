<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'AV Wellcare Diagnostics') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f1f5f9;
            padding: 30px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            padding: 28px 32px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            color: #ccfbf1;
            margin: 4px 0 0;
            font-size: 13px;
        }
        .content {
            padding: 32px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-primary {
            background-color: #ccfbf1;
            color: #0f766e;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #b45309;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
            border-bottom: 1px dashed #e2e8f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #64748b;
            font-weight: 500;
        }
        .info-value {
            color: #0f172a;
            font-weight: 600;
            text-align: right;
        }
        .btn {
            display: inline-block;
            background-color: #0d9488;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            margin-top: 16px;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 32px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        .footer a {
            color: #0d9488;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="center">
                    <div class="container">
                        <!-- Header -->
                        <div class="header">
                            <h1>AV Wellcare Diagnostics</h1>
                            <p>Reliable Diagnostics at Your Doorstep</p>
                        </div>

                        <!-- Main Content -->
                        <div class="content">
                            @yield('content')
                        </div>

                        <!-- Footer -->
                        <div class="footer">
                            <p style="margin: 0 0 8px;">Need assistance? We're here to help.</p>
                            <p style="margin: 0 0 8px;">
                                <strong>Call:</strong> +91 98765 43210 &nbsp;|&nbsp;
                                <strong>Email:</strong> <a href="mailto:support@avwellcare.com">support@avwellcare.com</a>
                            </p>
                            <p style="margin: 12px 0 0; font-size: 11px; color: #cbd5e1;">
                                &copy; {{ date('Y') }} AV Wellcare Diagnostics. All rights reserved.
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
