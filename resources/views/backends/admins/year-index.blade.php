@extends('backends.layout')

@section('content')

    <h2>รายการปีโครงการ</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="5">
                <a href="/backend/year/addForm" class="ui labeled icon button">
                    <i class="plus icon"></i>
                    เพิ่มปี
                </a>
            </th>
        </tr>
        <tr>
            <th>ลำดับ</th>
            <th>ปี</th>
        </tr>
        </thead>
        <tbody>
        @foreach($years as $year)
            <tr>
                <td>{{$year->id}}</td>
                <td>{{$year->year}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
