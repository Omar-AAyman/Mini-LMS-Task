@extends('emails.layout', ['title' => 'Welcome to ' . config('app.name')])

@section('content')
    <h2 style="margin: 0 0 16px 0; color: #0f172a; font-size: 24px; font-weight: 800; letter-spacing: -0.02em;">
        Hi {{ explode(' ', $user->name)[0] }},
    </h2>
    <p style="margin: 0 0 24px 0; font-size: 16px; color: #475569;">
        We're thrilled to have you join the <strong>Career 180</strong> community. You've just taken the first step toward
        masterng new skills and accelerating your career growth.
    </p>

    <div
        style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
        <h3 style="margin: 0 0 8px 0; color: #0f172a; font-size: 16px; font-weight: 700;">What's next?</h3>
        <p style="margin: 0; font-size: 14px; color: #64748b; line-height: 1.6;">
            Your learning dashboard is ready. Explore our range of industry-expert courses, enroll in what excites you, and
            track your progress as you learn.
        </p>
    </div>

    <div style="text-align: center;">
        <a href="{{ config('app.url') }}"
            style="background-color: #3b82f6; color: #ffffff; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; display: inline-block; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.25);">
            Go to My Dashboard
        </a>
    </div>

    <p style="margin: 40px 0 0; font-size: 14px; color: #94a3b8; text-align: center;">
        Need help getting started? Check out our <a href="{{ config('app.url') }}"
            style="color: #3b82f6; text-decoration: underline;">help center</a> or reply to this email.
    </p>
@endsection
