@extends('backends.layout')

@section('content')

    <h2>เพิ่มรายการคณะ</h2>

    @include('backends.admins.faculty-form', ['action' => '/backend/faculty/doAdd','cancel' => '/backend/faculty'])


@endsection
