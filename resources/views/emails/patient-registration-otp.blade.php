@extends('emails.layouts.base')

@section('title', 'Verify Your Email - AV Wellcare Diagnostics')

@section('content')
<div style="text-align: center; margin-bottom: 24px;">
    <div style="display: inline-block; width: 56px; height: 56px; background-color: #f0fdfa; border-radius: 50%; line-height: 56px; text-align: center; border: 2px solid #ccfbf1;">
        <span style="font-size: 26px;">🔐</span>
    </div>
    <h2 style="color: #0f172a; font-size: 20px; font-weight: 800; margin: 12px 0 4px;">Email Verification Code</h2>
    <p style="color: #64748b; font-size: 13px; margin: 0;">Complete your patient registration</p>
</div>

<p style="font-size: 14px; color: #334155; line-height: 1.6; margin-bottom: 16px;">
    Hello <strong>{{ $name }}</strong>,
</p>

<p style="font-size: 14px; color: #334155; line-height: 1.6; margin-bottom: 20px;">
    Thank you for choosing <strong>AV Wellcare Diagnostics</strong>. To complete your registration and activate your account, please enter the following one-time verification code:
</p>

<div style="text-align: center; margin: 28px 0;">
    <div style="display: inline-block; padding: 14px 32px; background: #f0fdfa; border: 2px dashed #0d9488; border-radius: 12px;">
        <span style="font-family: 'Courier New', Courier, monospace; font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #0f766e;">{{ $otp }}</span>
    </div>
    <p style="color: #64748b; font-size: 12px; margin-top: 10px;">
        ⏳ This code will expire in <strong>15 minutes</strong>.
    </p>
</div>

<div style="background-color: #f8fafc; border-left: 4px solid #0d9488; padding: 12px 16px; border-radius: 0 8px 8px 0; margin-bottom: 24px;">
    <p style="font-size: 12px; color: #475569; margin: 0; line-height: 1.5;">
        <strong>Security Notice:</strong> Never share this OTP with anyone, including staff from AV Wellcare Diagnostics. If you did not request this registration, you can safely ignore this email.
    </p>
</div>

<p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 0;">
    Warm regards,<br>
    <strong>AV Wellcare Diagnostics Team</strong>
</p>
@endsection
