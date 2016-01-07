@extends('backends.layout')

@section('content')

    <h2>รายการสิทธิ์</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th>ลำดับ</th>
            <th>คีย์</th>
            <th>ชื่อสิทธิ์</th>
            <th>รายละเอียด</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->key}}</td>
                <td>{{$role->name}}</td>
                <td>{{$role->description}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
