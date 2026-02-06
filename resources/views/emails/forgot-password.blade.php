@extends('emails.layouts.base')

@section('title', 'Reset Your Password - The Code Helper')

@section('content')
    <!-- Icon -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <div style="width: 70px; height: 70px; background-color: #fff3cd; border-radius: 50%; display: inline-block; line-height: 70px; font-size: 32px;">
                    🔐
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 600; color: #333333; margin: 0 0 20px 0; text-align: center;">
        Password Reset Request
    </h1>
    
    <!-- Message -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 20px 0; text-align: center;">
        Hi{{ isset($user->first_name) ? ' ' . $user->first_name : '' }},
    </p>
    
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 30px 0; text-align: center;">
        We received a request to reset your password. Use the verification code below to complete the process.
    </p>
    
    <!-- OTP Code Box -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <div style="background-color: #f8f9fa; border: 2px dashed #1a73e8; border-radius: 8px; padding: 25px 40px; display: inline-block;">
                    <span style="font-family: 'Courier New', monospace; font-size: 36px; font-weight: bold; color: #1a73e8; letter-spacing: 8px;">
                        {{ $user->otp }}
                    </span>
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Expiry Notice -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888; line-height: 22px; margin: 20px 0; text-align: center;">
        ⏰ This code will expire in <strong>10 minutes</strong>.
    </p>
    
    <!-- Security Notice -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
        <tr>
            <td style="background-color: #fff8e1; border-left: 4px solid #ffc107; padding: 15px; border-radius: 4px;">
                <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #856404; margin: 0;">
                    <strong>⚠️ Security Tip:</strong> If you didn't request this password reset, please ignore this email. Your password will remain unchanged.
                </p>
            </td>
        </tr>
    </table>
@endsection