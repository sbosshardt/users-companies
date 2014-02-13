<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Users Companies - @yield('title')</title>
        {{HTML::style('uc/base.css')}}
        @yield('css')
        {{HTML::script('uc/base.js')}}
        @yield('js')
    </head>
    <body>
        @yield('body')
    </body>
</html>