@extends('emails.layouts.base')

@section('title', 'Welcome to The Code Helper')

@section('content')
    <!-- Icon -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <div style="width: 70px; height: 70px; background-color: #e7f3ff; border-radius: 50%; display: inline-block; line-height: 70px; font-size: 32px;">
                    👋
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 600; color: #1a73e8; margin: 0 0 20px 0; text-align: center;">
        Welcome to The Code Helper!
    </h1>
    
    <!-- Message -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 20px 0; text-align: center;">
        Hi {{ $user->first_name ?? 'there' }},
    </p>
    
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 30px 0; text-align: center;">
        Thank you for joining The Code Helper! We're excited to have you on board. Your account has been created successfully.
    </p>
    
    <!-- What's Next Box -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin-bottom: 30px;">
        <tr>
            <td style="padding: 25px;">
                <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #333333; margin: 0 0 20px 0;">
                    🚀 Get Started
                </h3>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="padding: 10px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #555555;">
                                ✅ <strong>Complete your profile</strong> - Add your skills and experience
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #555555;">
                                ✅ <strong>Browse projects</strong> - Find opportunities that match your skills
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #555555;">
                                ✅ <strong>Connect Stripe</strong> - Set up payments to receive funds
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- CTA Button -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <a href="https://thecodehelper.com/user/dashboard" 
                   style="background-color: #1a73e8; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 40px; border-radius: 6px; display: inline-block;">
                    Go to Dashboard →
                </a>
            </td>
        </tr>
    </table>
    
    <!-- Help Notice -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="background-color: #e7f3ff; border-left: 4px solid #1a73e8; padding: 15px; border-radius: 4px;">
                <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #004085; margin: 0;">
                    <strong>💬 Need Help?</strong> Contact us anytime at <a href="mailto:support@thecodehelper.com" style="color: #1a73e8;">support@thecodehelper.com</a>
                </p>
            </td>
        </tr>
    </table>
@endsection
