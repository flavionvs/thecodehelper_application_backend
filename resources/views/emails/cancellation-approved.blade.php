@extends('emails.layouts.base')

@section('title', 'Project Cancellation Approved - The Code Helper')

@section('content')
    <!-- Icon -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <div style="width: 70px; height: 70px; background-color: {{ $type === 'refund' ? '#d4edda' : '#cce5ff' }}; border-radius: 50%; display: inline-block; line-height: 70px; font-size: 32px;">
                    {{ $type === 'refund' ? '💰' : '✅' }}
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 600; color: {{ $type === 'refund' ? '#28a745' : '#007bff' }}; margin: 0 0 20px 0; text-align: center;">
        Project Cancellation Approved
    </h1>
    
    <!-- Message -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 20px 0; text-align: center;">
        Hi {{ $user_name ?? 'there' }},
    </p>
    
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 30px 0; text-align: center;">
        {{ $email_message }}
    </p>
    
    <!-- Project Summary Box -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin-bottom: 30px;">
        <tr>
            <td style="padding: 25px;">
                <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 1px;">
                    Project Details
                </h3>
                <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 20px; color: #333333; margin: 0 0 15px 0;">
                    {{ $project_title ?? 'Your Project' }}
                </h2>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Project ID:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333; font-weight: 600;">#{{ $project_id ?? '0' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Status:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #dc3545; font-weight: 600;">Cancelled</span>
                        </td>
                    </tr>
                    @if(isset($amount))
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">{{ $type === 'refund' ? 'Refund Amount:' : 'Transfer Amount:' }}</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: {{ $type === 'refund' ? '#28a745' : '#007bff' }}; font-weight: 600;">${{ number_format($amount, 2) }}</span>
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
    
    <!-- CTA Button -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 10px 0 30px 0;">
                <a href="https://thecodehelper.com/user/project?type=cancelled" style="background-color: #1a73e8; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 40px; border-radius: 6px; display: inline-block;">
                    View Project
                </a>
            </td>
        </tr>
    </table>
@endsection
