<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>TaskList</title>

  <link href="{{ mix('css/main.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app"></div>

  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
