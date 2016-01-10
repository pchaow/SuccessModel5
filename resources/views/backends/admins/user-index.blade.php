@extends('backends.layout')

@section('content')

    <h2>รายการสิทธิ์</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="5">
                <a href="/backend/user/addForm" class="ui labeled icon button">
                    <i class="plus icon"></i>
                    เพิ่มผู้ใช้
                </a>
                <div class="ui right floated menu">
                    <div class="item">
                        <div class="ui transparent icon input">
                            <input type="text" placeholder="Search...">
                            <i class="search link icon"></i>
                        </div>
                    </div>
                </div>

            </th>
        </tr>
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อ นามสกุล</th>
            <th>คณะ</th>
            <th>บทบาท</th>
            <th>การจัดการ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->title}}{{$user->firstname}} {{$user->lastname}}</td>
                <td>{{$user->faculty->name_th or ""}}</td>
                <td>
                    @foreach($user->roles as $role)
                        {{$role->name}} <br/>
                    @endforeach
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

