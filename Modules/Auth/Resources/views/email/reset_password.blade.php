{{-- <!DOCTYPE html>
<html>

<head>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            text-align: center;
        }

        .logo {
            max-width: 150px;
            /* Adjust the size of your logo */
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-top: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            text-align: center;
            margin-top: 10px;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
            display: block;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ aurl('images/quroaa-logo.png') }}" alt="Your Logo">
        </div>

        <!-- Header -->
        <div class="header">
            <h1>Reset your password</h1>
        </div>

        <!-- Content -->
        <!-- resources/views/emails/password_reset.blade.php -->

        <p>
            We have received a password reset request from your account. To ensure the security of your
            {{ config('app.name') }} account, please follow the instructions below to reset your password:
        </p>

        <ol>
            <li>Open the {{ config('app.name') }} application.</li>
            <li>Navigate to the password reset page.</li>
            <li>Enter the following token when prompted:</li>
        </ol>

        <p>
            <strong>Password Reset Token:</strong> {{ $code }}
        </p>

        <p>
            If you did not request this password reset, please disregard this email. Your account remains secure. If you
            have any questions or need assistance, please don't hesitate to contact our support team at
            {{ config('mail.support_email') }}.
        </p>

        <p>
            Thank you for choosing {{ config('app.name') }}. We appreciate your trust in our service.
        </p>

    </div>
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>
</body>

</html>
 --}}




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        /* Reset some default styles for cross-client compatibility */
        body,
        p {
            margin: 0;
            padding: 0;
        }

        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 24px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            text-align: left;
            margin-top: 10px;
            padding: 0 20px;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
            display: block;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <div class="header">
            {{-- <img class="logo" src="https://example.com/images/quroaa-logo.png" alt="Your Logo"> --}}
            <h1>Password Reset</h1>
        </div>

        <!-- Content -->
        <p>
            We have received a password reset request from your account. To ensure the security of your
            {{ config('app.name') }} account, please follow the instructions below to reset your password:
        </p>

        <ol>
            <li>Open the {{ config('app.name') }} application.</li>
            <li>Navigate to the password reset page.</li>
            <li>Enter the following token when prompted:</li>
        </ol>

        <p>
            <strong>Password Reset Token:</strong> {{ $code }}
        </p>

        <p>
            If you did not request this password reset, please disregard this email. Your account remains secure. If you
            have any questions or need assistance, please don't hesitate to contact our support team at
            {{ config('mail.support_email') }}.
        </p>

        <p>
            Thank you for choosing {{ config('app.name') }}. We appreciate your trust in our service.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>
</body>

</html>
