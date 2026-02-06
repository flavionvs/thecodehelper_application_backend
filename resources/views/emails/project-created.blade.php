@extends('emails.layouts.base')

@section('title', 'Project Created - The Code Helper')

@section('content')
    <!-- Icon -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <div style="width: 70px; height: 70px; background-color: #e3f2fd; border-radius: 50%; display: inline-block; line-height: 70px; font-size: 32px;">
                    🚀
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 24px; font-weight: 600; color: #333333; margin: 0 0 20px 0; text-align: center;">
        Your Project Has Been Created!
    </h1>
    
    <!-- Message -->
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 20px 0; text-align: center;">
        Hi{{ isset($client_name) ? ' ' . $client_name : '' }},
    </p>
    
    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; color: #555555; line-height: 26px; margin: 0 0 30px 0; text-align: center;">
        Great news! Your project has been successfully created and is now visible to freelancers.
    </p>
    
    <!-- Project Info Box -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin-bottom: 20px;">
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
                    @if(isset($project_budget) && $project_budget)
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Budget:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333; font-weight: 600;">${{ $project_budget }}</span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding: 5px 0;">
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Your Email:</span>
                            <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333333;">{{ $client_email ?? '' }}</span>
                        </td>
                    </tr>
                </table>
                @if(isset($project_description) && $project_description)
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                    <span style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #888888;">Description:</span>
                    <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #555555; margin: 5px 0 0 0; line-height: 22px;">
                        {{ $project_description }}
                    </p>
                </div>
                @endif
            </td>
        </tr>
    </table>
    
    <!-- CTA Button -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <a href="https://thecodehelper.com/user/project?type=my-projects" 
                   style="background-color: #1a73e8; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 40px; border-radius: 6px; display: inline-block;">
                    View My Projects →
                </a>
            </td>
        </tr>
    </table>
    
    <!-- What's Next -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="background-color: #e8f5e9; border-left: 4px solid #4caf50; padding: 15px; border-radius: 4px;">
                <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #2e7d32; margin: 0;">
                    <strong>📋 What's Next?</strong> Talented freelancers will start applying to your project. You'll receive notifications when new applications arrive.
                </p>
            </td>
        </tr>
    </table>
@endsection
