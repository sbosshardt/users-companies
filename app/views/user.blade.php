@extends('base')

@section('title'){{--@parent--}}<?php echo "Users"; ?>@stop

@section('css')
    {{HTML::style('uc/css/user.css')}}
@stop


@section('userlisting')
    <?php
    $userdata = $response['userdata'];
    ?>
    <h1>User Details</h1>
    <table>
        <tbody>
            <tr>
                <td>uid:</td>
                <td>{{$userdata['uid']}}</td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td>{{$userdata['firstname']}}</td>
            </tr>
            <tr>
                <td>Surname:</td>
                <td>{{$userdata['surname']}}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{$userdata['email']}}</td>
            </tr>
            <tr>
                <td>company_uid:</td>
                <td>{{$userdata['company_uid']}}</td>
            </tr>
            <tr>
                {{--
                    Not sure how to get Laravel hyperlinks to work
                    Tried using URL::action('UserController@edit')
                    http://laravel.com/docs/controllers
                --}}
                <td colspan='2'><a href='./{{$userdata['uid']}}/edit'>Edit Record</a></td>
            </tr>
        </tbody>
    </table>
@stop

@section('body')
    <div>
        @yield('userlisting')
    </div>
@stop


