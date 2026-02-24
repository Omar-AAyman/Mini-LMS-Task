<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; line-height: 1.5; color: #1e293b;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background-color: #f8fafc; padding: 48px 24px;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">

                    {{-- Header Area --}}
                    @isset($header)
                        <tr>
                            <td align="center" style="padding: 48px 40px; background-color: #0f172a; color: #ffffff;">
                                {{ $header }}
                            </td>
                        </tr>
                    @endisset

                    {{-- Main Content --}}
                    <tr>
                        <td style="padding: 48px 40px;">
                            @yield('content')
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center"
                            style="padding: 32px 40px; background-color: #f1f5f9; border-top: 1px solid #e2e8f0;">
                            <p
                                style="margin: 0; font-size: 14px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                {{ config('app.name') }}
                            </p>
                            <p style="margin: 8px 0 0; font-size: 12px; color: #94a3b8;">
                                &copy; {{ date('Y') }} Career 180. Helping you reach your full potential.
                            </p>
                            <div style="margin-top: 16px;">
                                <a href="{{ config('app.url') }}"
                                    style="color: #3b82f6; text-decoration: none; font-size: 12px; font-weight: 500;">Visit
                                    Website</a>
                                <span style="margin: 0 8px; color: #cbd5e1;">&bull;</span>
                                <a href="mailto:support@career180.com"
                                    style="color: #3b82f6; text-decoration: none; font-size: 12px; font-weight: 500;">Support</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
