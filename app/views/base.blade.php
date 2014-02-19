<?php 
$pages = array();
$pages["Users"] = 'user';
$pages["Companies"] = 'companies';

$ContextRoot = ROUTES_UC_CONTEXT_ROOT . "users-companies/public/";
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Users / Companies - @yield('title')</title>
        {{HTML::style('lib/uc/css/base.css')}}
        @yield('css')
        {{HTML::script('lib/uc/css/base.js')}}
        @yield('js')
    </head>
    <body>
        <div class='topnavigation'>
            <ul class='topnavigation'>
                @foreach ($pages as $name => $uri)
                <?php
                    //$ClassLabel = ($ContextRoot . $uri == $_SERVER['REQUEST_URI']) ? "topnavigation.current" : "topnavigation";
                    $ClassLabel = 'topnavigation';
                ?>
                    <li class='topnavigation'><a class='{{$ClassLabel}}' href="{{$ContextRoot . $uri}}" title="{{$name}}">{{$name}}</a></li>
                @endforeach
            </ul>
        </div>
        @yield('body')
    </body>
</html>