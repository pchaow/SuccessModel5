@extends('backends.layout')

@section('content')

    <h2>แก้ไขรายการคณะ</h2>


    @include('backends.faculty-form', ['action' => "/backend/faculty/$faculty->id/doEdit",'cancel' => '/backend/faculty'])

@endsection
