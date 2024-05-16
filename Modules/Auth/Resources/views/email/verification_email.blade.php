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
            <img src="{{ aurl('images/quroaa-logo.png') }}" alt="Qor3ah Logo">
        </div>

        <!-- Header -->
        <div class="header">
            <h1>Verify your email</h1>
        </div>

        <!-- Content -->
        <p>Welcome to {{ config('app.name') }}! Please use the following code to confirm your email address and complete
            the registration process:</p>
        <p>Please use this code: <span class="code">{{ $details['code'] }}</span></p>
        <p>Thank you, {{ config('app.name') }}</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>
</body>

</html>
 --}}


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
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
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
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
            text-align: center;
            margin-top: 10px;
            padding: 0 20px;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
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
            {{-- <img class="logo" src="https://example.com/images/quroaa-logo.png" alt="Qor3ah Logo"> --}}
<h1>Verify your email</h1>
</div>

<!-- Content -->
<p>Welcome to {{ config('app.name') }}! Please use the following code to confirm your email address and complete
    the registration process:</p>
<p>Please use this code: <span class="code">{{ $details['code'] }}</span></p>
<p>Thank you, {{ config('app.name') }}</p>
</div>
<div class="footer">
    &copy; {{ date('Y') }} {{ config('app.name') }}
</div>
</body>

</html> --}}
