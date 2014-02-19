@extends('base')

@section('title'){{--@parent--}}<?php echo "Users"; ?>@stop

@section('css')
    {{HTML::style('uc/css/user.css')}}
@stop


@section('userlisting')
    <h1>User Details</h1>
    <table>
        <tbody>
            <tr>
                <td>uid:</td>
                <td>{{$stuff['response'][0]['uid']}}</td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td>{{$stuff['response'][0]['firstname']}}</td>
            </tr>
            <tr>
                <td>Surname:</td>
                <td>{{$stuff['response'][0]['surname']}}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{$stuff['response'][0]['email']}}</td>
            </tr>
            <tr>
                <td>company_uid:</td>
                <td>{{$stuff['response'][0]['company_uid']}}</td>
            </tr>
        </tbody>
    </table>
@stop

@section('body')
    <div>
        <?php
        //var_dump($stuff);
        ?>
        @yield('userlisting')
    </div>
@stop


