@extends('backends.layout')

@section('content')

    <h2>รายการโครงการ</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="7">
                <a href="/backend/projects/addForm" class="ui labeled icon button">
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
            <th style="width:10em;">สถานะโครงการ</th>
            <th>ส่งแบบ</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="center aligned collapsing">{{$project->id}}</td>
                <td>
                    <b>{{$project->name_th}}</b><br/>
                    {{$project->name_en}}
                </td>
                <td class="collapsing">{{$project->faculty->name_th or "" }}</td>
                <td class="center aligned">
                    <?php
                    $dataPercent = 0;
                    if ($project->status->key == 'draft') $dataPercent = 1;
                    elseif ($project->status->key == 'faculty')
                        $dataPercent = 2;
                    elseif ($project->status->key == 'university')
                        $dataPercent = 3;
                    elseif ($project->status->key == 'published')
                        $dataPercent = 4;
                    ?>
                        <div class="ui progress" data-value="{{$dataPercent}}" data-total="4">
                        <div class="bar">
                        </div>
                        <div class="label">{{$project->status->name}}</div>
                    </div>

                </td>
                <td class="center aligned collapsing">
                    <form class="inline" id="frmSubmit_{{$project->id}}" method="post"
                          action="/backend/projects/{{$project->id}}/submit">
                        {{csrf_field()}}

                        <button type="button" class="ui green icon   button" onclick="askSubmitProject({{$project->id}});">
                            <i class="forward mail icon icon"></i>
                        </button>
                    </form>
                </td>
                <td class="center aligned collapsing">
                    <a href="/backend/projects/{{$project->id}}/edit" class="ui icon blue button">
                        <i class="edit icon"></i>
                    </a>
                </td>
                <td class="center aligned collapsing">


                    <form class="inline" id="frmdelete_{{$project->id}}" method="post"
                          action="/backend/projects/{{$project->id}}/delete">
                        {{csrf_field()}}

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
            <th colspan="7">
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


    <script type="text/javascript">

        function askDeleteProject(id) {
            if (confirm('คุณต้องการลบโครงการนี้ ใช่หรือไม่')) {
                var frmid = "#frmdelete_" + id;
                $(frmid).submit();
            }
        }

        $('.ui.progress').progress({
            total: 4
        });


    </script>
@endsection
