<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Abel|Anton|Fjalla+One" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/main.css">
        <title>Booster Rater - @yield('title')</title>
    </head>
    <body>
        <div class="container">
            <h1 class="title">@yield('title')</h1>
            <div id="app" class="main">
                @yield('content')
            </div>
            <div class="footer">
                <p>Copyright &copy 2019 by Craig Reeves</p>
            </div>
        </div>
    </body>
    <script>
        window.page = window.page || {};
    </script>
    @yield('script_vars')
    <script>
        window.page.csrf_token = "{{ csrf_token() }}"
    </script>
    <script src="js/app.js"></script>
</html>
