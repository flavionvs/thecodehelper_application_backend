@extends('emails.layouts.base')

@section('title', 'New Application Received - The Code Helper')

@section('content')
    <!-- Icon -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <div style="width: 70px; height: 70px; background-color: #cce5ff; border-radius: 50%; display: inline-block; line-height: 70px; font-size: 32px;">
                    📬
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 600; color: #1a73e8; margin: 0 0 20px 0; text-align: center;">
        New Application Received!
    </h1>
    
    <!-- Message -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 20px 0; text-align: center;">
        Hi {{ $client_name ?? 'there' }},
    </p>
    
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 30px 0; text-align: center;">
        A freelancer has applied to work on your project. Review their application and profile to decide if they're the right fit.
    </p>
    
    <!-- Application Details Box -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin-bottom: 30px;">
        <tr>
            <td style="padding: 25px;">
                <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888; margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 1px;">
                    Application Details
                </h3>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Project ID:</span>
                        </td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef; text-align: right;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333;">#{{ $project_id ?? '0' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Project:</span>
                        </td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef; text-align: right;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333; font-weight: 600;">{{ $project_title ?? 'Your Project' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Applicant:</span>
                        </td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef; text-align: right;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333;">{{ $freelancer_name ?? 'Freelancer' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Your Email:</span>
                        </td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef; text-align: right;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333;">{{ $client_email ?? '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Proposed Amount:</span>
                        </td>
                        <td style="padding: 8px 0; text-align: right;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #1a73e8; font-weight: 700;">${{ $amount ?? '0' }}</span>
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
                <a href="https://thecodehelper.com/user/applications/{{ $project_id ?? '' }}" 
                   style="background-color: #1a73e8; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 40px; border-radius: 6px; display: inline-block;">
                    Review Application →
                </a>
            </td>
        </tr>
    </table>
    
    <!-- Tip -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="background-color: #e7f3ff; border-left: 4px solid #1a73e8; padding: 15px; border-radius: 4px;">
                <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #004085; margin: 0;">
                    <strong>💡 Tip:</strong> Check the freelancer's profile to see their skills, experience, and past reviews before making your decision.
                </p>
            </td>
        </tr>
    </table>
@endsection
