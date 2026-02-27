<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'The Code Helper')</title>
    <style>
        /* Reset styles */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        
        /* Remove spacing */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
        /* iOS blue links */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        
        /* Mobile styles */
        @media screen and (max-width: 600px) {
            .mobile-padding { padding: 20px !important; }
            .mobile-stack { display: block !important; width: 100% !important; }
        }
    </style>
</head>
<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    
    <!-- Main Table -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                
                <!-- Email Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px;">
                    
                    <!-- Logo Header -->
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="https://thecodehelper.com" target="_blank" style="text-decoration: none;">
                                            <img src="https://thecodehelper-api.azurewebsites.net/images/logo.png" 
                                                 alt="The Code Helper" 
                                                 width="150" 
                                                 height="150"
                                                 style="display: block; width: 150px; max-width: 150px; height: auto; border: 0;" />
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Email Body -->
                    <tr>
                        <td align="center">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <tr>
                                    <td class="mobile-padding" style="padding: 40px;">
                                        @yield('content')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 30px 0;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #666666; line-height: 20px;">
                                        <p style="margin: 0;">© {{ date('Y') }} The Code Helper. All rights reserved.</p>
                                        <p style="margin: 10px 0 0 0;">
                                            <a href="https://thecodehelper.com" style="color: #1a73e8; text-decoration: none;">Visit Website</a> |
                                            <a href="https://thecodehelper.com/privacy-policy" style="color: #1a73e8; text-decoration: none;">Privacy Policy</a> |
                                            <a href="https://thecodehelper.com/terms-and-conditions" style="color: #1a73e8; text-decoration: none;">Terms of Service</a>
                                        </p>
                                        <p style="margin: 15px 0 0 0; color: #999999;">
                                            This email was sent to you because you have an account with The Code Helper.<br>
                                            If you didn't request this email, please ignore it.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>
