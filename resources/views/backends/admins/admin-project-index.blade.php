@extends('backends.layout')

@section('content')

    <h2>รายการโครงการ</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="5">
                <a href="/backend/admin/project/addForm" class="ui labeled icon button">
                    <i class="plus icon"></i>
                    เพิ่มรายการโครงการ
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
            <th>ชื่อโครงการ</th>
            <th>กอง/คณะ/วิทยาลัย</th>
            <th>สถานะโครงการ</th>
            <th>การจัดการ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="center aligned collapsing">{{$project->id}}</td>
                <td>
                    {{$project->name_th}}
                    {{$project->name_en}}
                </td>
                <td class="collapsing">{{$project->faculty->name_th}}</td>
                <td class="center aligned collapsing">{{$project->project_status->name}}</td>
                <td class="center aligned collapsing">


                    <form class="inline" id="frmdelete_{{$project->id}}" method="post"
                          action="/backend/faculty/{{$project->id}}/delete">

                        <a href="/backend/faculty/{{$project->id}}/edit" class="ui icon blue button">
                            <i class="edit icon"></i>
                        </a>

                        <button type="button" class="ui icon red  button" onclick="askDeleteProject({{$project->id}});">
                            <i class="trash icon"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="5">
                <div class="ui right floated pagination menu">
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="item">1</a>
                    <a class="item">2</a>
                    <a class="item">3</a>
                    <a class="item">4</a>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

@endsection
