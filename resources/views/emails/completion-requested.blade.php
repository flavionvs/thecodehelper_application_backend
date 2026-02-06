@extends('emails.layouts.base')

@section('title', 'Completion Requested - The Code Helper')

@section('content')
    <!-- Icon -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <div style="width: 70px; height: 70px; background-color: #fff3cd; border-radius: 50%; display: inline-block; line-height: 70px; font-size: 32px;">
                    📋
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 600; color: #856404; margin: 0 0 20px 0; text-align: center;">
        Project Completion Requested
    </h1>
    
    <!-- Message -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 20px 0; text-align: center;">
        Hi {{ $client_name ?? 'there' }},
    </p>
    
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 30px 0; text-align: center;">
        The freelancer has requested completion for your project. Please review the deliverables and either accept or request changes.
    </p>
    
    <!-- Project Details Box -->
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
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Freelancer:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333;">{{ $freelancer_name ?? 'Freelancer' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Your Email:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333;">{{ $client_email ?? '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Status:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #856404; font-weight: 600;">⏳ Awaiting Your Review</span>
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
                <a href="https://thecodehelper.com/user/project?type=ongoing" 
                   style="background-color: #1a73e8; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 40px; border-radius: 6px; display: inline-block;">
                    Review & Accept Completion →
                </a>
            </td>
        </tr>
    </table>
    
    <!-- Important Notice -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="background-color: #fff8e1; border-left: 4px solid #ffc107; padding: 15px; border-radius: 4px;">
                <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #856404; margin: 0;">
                    <strong>⚠️ Action Required:</strong> Please review the project deliverables carefully. Once you accept completion, the payment will be released to the freelancer.
                </p>
            </td>
        </tr>
    </table>
@endsection
