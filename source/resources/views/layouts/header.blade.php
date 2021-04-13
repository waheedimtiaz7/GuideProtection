<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($header)?$header:"Guide Shipping Protection" }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset("/") }}assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="{{ asset("/") }}assets/css/bundle.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link href="{{ asset("/") }}assets/css/style.css" rel="stylesheet">
    @if(Request::segment(1)=='success-page')
        <link href="{{ asset("assets/css/thank_you.css") }}" rel="stylesheet">
    @endif

</head>