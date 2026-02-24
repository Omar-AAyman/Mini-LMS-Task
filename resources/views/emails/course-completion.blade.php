@extends('emails.layout', ['title' => 'Congratulations! Course Completed'])

@section('content')
    <div style="text-align: center; margin-bottom: 32px;">
        <div
            style="background-color: #ecfdf5; color: #059669; width: 64px; height: 64px; border-radius: 50%; line-height: 64px; font-size: 32px; display: inline-block; margin-bottom: 24px;">
            🎓
        </div>
        <h2 style="margin: 0; color: #0f172a; font-size: 28px; font-weight: 800; letter-spacing: -0.02em;">
            Achievement Unlocked!
        </h2>
        <p style="margin: 8px 0 0; font-size: 18px; color: #64748b; font-weight: 500;">
            Congratulations, {{ explode(' ', $user->name)[0] }}!
        </p>
    </div>

    <p style="margin: 0 0 24px 0; font-size: 16px; color: #475569; text-align: center; line-height: 1.6;">
        We are incredibly proud of your dedication and hard work. You have successfully mastered every lesson and completed
        the course with flying colors.
    </p>

    <div
        style="background-color: #f1f5f9; border-radius: 16px; padding: 32px 24px; text-align: center; margin-bottom: 40px;">
        <p
            style="margin: 0 0 8px 0; font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;">
            Certified Completion
        </p>
        <h3 style="margin: 0; color: #2563eb; font-size: 22px; font-weight: 800; line-height: 1.3;">
            {{ $course->title }}
        </h3>
    </div>

    <div style="text-align: center;">
        <p style="margin: 0 0 24px 0; font-size: 15px; color: #64748b;">
            Don't stop now! Your momentum is at its peak. Why not start your next challenge today?
        </p>
        <a href="{{ config('app.url') }}"
            style="background-color: #0f172a; color: #ffffff; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; display: inline-block; box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.2);">
            Browse New Courses
        </a>
    </div>

    <p style="margin: 48px 0 0; font-size: 14px; color: #94a3b8; text-align: center; font-style: italic;">
        "The beautiful thing about learning is that no one can take it away from you." <br>— B.B. King
    </p>
@endsection
