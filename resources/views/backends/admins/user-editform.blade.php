@extends('backends.layout')

@section('content')

    <h2>แก้ไขผู้ใช้</h2>

    @include('backends.admins.user-form', ['action' => "/backend/user/$user->id/doEdit",'cancel' => '/backend/user'])


@endsection
