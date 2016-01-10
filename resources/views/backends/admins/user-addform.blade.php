@extends('backends.layout')

@section('content')

    <h2>เพิ่มผู้ใช้</h2>

    @include('backends.admins.user-form', ['action' => '/backend/user/doAdd','cancel' => '/backend/user'])


@endsection
