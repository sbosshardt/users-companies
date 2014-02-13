@extends('uc/base')

{{-- This is how you make a comment --}}

@section('title')@parent<?php echo "Users"; ?>@stop

@section('css')
    @parent
    {{HTML::style('uc/css/user.css')}}
@stop

@section('childContent')
    <div>
        <p>Wheeeeeeeeeeeee!</p>
    </div>
@stop