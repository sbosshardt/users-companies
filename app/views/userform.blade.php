@extends('base')

@section('userform')
<?php
$FormArray = array();

// default to posting a new user, unless we see that we are updating a user
$Action = array('UserController@store');
$method = "post";
if ($response['currentResourceName'] == "edit")
{
    $method = "put";
    $Action = array("UserController@update", $response['uid']);
}

$FormArray = array('action' => $Action, 'method' => $method);

?>
    {{ Form::open( $FormArray ) }}
        <?php
        if ($method == "post")
        {
            echo Form::label('uid', 'uid (any number not in use):');
            echo Form::text('uid') . "<br />";
        }
        ?>
        {{ Form::label('firstname', 'First Name:') }}
        {{ Form::text('firstname', @$response['userdata']['firstname'] ) }}
        <br />
        {{ Form::label('surname', 'Surname:') }}
        {{ Form::text('surname', @$response['userdata']['surname'] ) }}
        <br />
        {{ Form::label('email', 'Email:') }}
        {{ Form::text('email', @$response['userdata']['email'] ) }}
        <br />
        {{ Form::label('company_uid', 'company_uid:') }}
        {{ Form::text('company_uid', @$response['userdata']['company_uid'] ) }}
        <br />
        {{ Form::submit( ucfirst($response['currentResourceName'])." User" ) }}
        
    {{ Form::close() }}
    
<?php
// if this form is on the Edit User page, we need to make a second form to
// provide functionality to delete users.
if ($method == "put")
{
    $DelAction = array("UserController@destroy", $response['uid']);
    $DeleteForm = array('action' => $DelAction, 'method' => 'delete');
    echo '<br /><br />';
    echo Form::open($DeleteForm);
        echo Form::submit("Delete User");
    echo Form::close();
}
?>
    
@stop

@section('body')
<div>
    <table style="text-align: right;">
        <tr><td>@yield('userform')</td></tr>
    </table>
</div>
@stop