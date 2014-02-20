@extends('base')

@section('title'){{--@parent--}}<?php echo "Users"; ?>@stop

@section('css')
    {{HTML::style('uc/css/user.css')}}
@stop


@section('uidslisting')
    <h1>List of uids</h1>
    <p>[ <a href="user/create">Create a User</a> ]</p>
    @foreach ($response['uidlist'] as $resp)
        <p><a href="user/{{$resp['uid']}}">{{$resp['uid']}}</a></p>
    @endforeach
@stop


@section('body')
    <div>
        @yield('uidslisting')
    </div>
@stop


