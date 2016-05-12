@extends('backends.layout')

@section('content')

    <h2>เพิ่มรายการคณะ</h2>

    @include('backends.admins.year-form', ['action' => '/backend/year/doAdd','cancel' => '/backend/year'])


@endsection
