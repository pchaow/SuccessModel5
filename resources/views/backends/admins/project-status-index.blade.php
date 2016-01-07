@extends('backends.layout')

@section('content')

    <h2>รายการสถานะโครงการ</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th>ลำดับ</th>
            <th>คีย์</th>
            <th>ชื่อรายการ</th>
            <th>รายละเอียด</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statuses as $status)
            <tr>
                <td>{{$status->id}}</td>
                <td>{{$status->key}}</td>
                <td>{{$status->name}}</td>
                <td>{{$status->description}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
