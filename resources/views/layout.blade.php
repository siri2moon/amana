<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/amana/img/favicon.png') }}">

    <title>Amana</title>

    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset(mix($cssFile, 'vendor/amana')) }}" rel="stylesheet" type="text/css">
</head>
<body>
<div id="amana" v-cloak>
</div>

<!-- Global Amana Object -->
<script>
    window.Amana = @json($amanaScriptVariables);
</script>

<script src="{{asset(mix('app.js', 'vendor/amana'))}}"></script>
</body>
</html>
