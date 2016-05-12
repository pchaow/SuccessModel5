@if($role=="RESEARCHER")
    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="7">
                <a href="/backend/project/addForm" class="ui labeled icon button">
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
            <th>ปี</th>
            <th>ชื่อโครงการ</th>
            <th>กอง/คณะ/วิทยาลัย</th>
            <th style="width:15em;">สถานะโครงการ</th>
            <th>ตัวอย่าง</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="center aligned collapsing">{{$project->year}}</td>
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
                    @if($project->status->key=="draft")

                        <button data-id="{{$project->id}}" type="button"
                                class="ui icon green  button projectSubmitBtn">
                            <i class="external icon"></i>
                        </button>
                    @else
                        <a class="ui icon green button" target="_blank"
                           href="/backend/preview/project/{{$project->id}}/previewOnly">
                            <i class="external icon"></i>
                        </a>
                    @endif
                </td>
                <td class="center aligned collapsing">
                    @if($project->status->key=="draft")
                        <a href="/backend/project/{{$project->id}}/edit" class="ui icon blue button">
                            <i class="edit icon"></i>
                        </a>
                    @endif
                </td>
                <td class="center aligned collapsing">
                    @if($project->status->key=="draft")
                        <form class="inline" id="frmdelete_{{$project->id}}" method="post"
                              action="/backend/project/{{$project->id}}/delete">
                            {{csrf_field()}}

                            <button type="button" class="ui icon red  button deleteProjectBtn">
                                <i class="trash icon"></i>
                            </button>
                        </form>
                    @endif
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
    <script>
        $(".projectSubmitBtn").on('click', function () {
            var projectId = $(this).attr('data-id');
            var win = window.open('/backend/preview/project/' + projectId + "/researcher", "_blank");
        })

        function reload() {
            location.reload();
        }
    </script>
@elseif($role=="FACULTY")
    <table class="ui celled table">
        <thead>
        <tr>
            <th>ปี</th>
            <th>ชื่อโครงการ</th>
            <th>กอง/คณะ/วิทยาลัย</th>
            <th style="width:15em;">สถานะโครงการ</th>
            <th>ตัวอย่าง</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="center aligned collapsing">{{$project->year}}</td>
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
                    @if($project->status->key == 'faculty')
                        <button data-id="{{$project->id}}" type="button"
                                class="ui icon green  button projectSubmitBtn">
                            <i class="external icon"></i>
                        </button>
                    @else
                        <a class="ui icon green button" target="_blank"
                           href="/backend/preview/project/{{$project->id}}/previewOnly">
                            <i class="external icon"></i>
                        </a>
                    @endif
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
    <script>
        $(".projectSubmitBtn").on('click', function () {
            var projectId = $(this).attr('data-id');
            var win = window.open('/backend/preview/project/' + projectId + "/faculty", "_blank");
        })

        function reload() {
            location.reload();
        }
    </script>
@elseif($role=="UNIVERSITY")
    <table class="ui celled table">
        <thead>
        <tr>
            <th>ปี</th>
            <th>ชื่อโครงการ</th>
            <th>กอง/คณะ/วิทยาลัย</th>
            <th style="width:15em;">สถานะโครงการ</th>
            <th>ตัวอย่าง</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="center aligned collapsing">{{$project->year}}</td>
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
                    @if($project->status->key == 'university')
                        <button data-id="{{$project->id}}" type="button"
                                class="ui icon green button projectSubmitBtn">
                            <i class="external icon"></i>
                        </button>
                    @else
                        <a class="ui icon green button" target="_blank"
                           href="/backend/preview/project/{{$project->id}}/previewOnly">
                            <i class="external icon"></i>
                        </a>
                    @endif
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
    <script>
        $(".projectSubmitBtn").on('click', function () {
            var projectId = $(this).attr('data-id');
            var win = window.open('/backend/preview/project/' + projectId + "/university", "_blank");
        })

        function reload() {
            location.reload();
        }
    </script>
@elseif($role=="ADMIN")
    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="6">
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
            <th>ปี</th>
            <th>ชื่อโครงการ</th>
            <th>กอง/คณะ/วิทยาลัย</th>
            <th>สถานะโครงการ</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td class="center aligned collapsing">{{$project->year}}</td>
                <td>
                    <b>{{$project->name_th}}</b><br/>
                    {{$project->name_en}}
                </td>
                <td class="collapsing">{{$project->faculty->name_th or "" }}</td>
                <td style="width:15em;" class="center aligned">
                    <?php
                    $dataPercent = 0;
                    if ($project->status) {
                        if ($project->status->key == 'draft')
                            $dataPercent = 1;
                        elseif ($project->status->key == 'faculty')
                            $dataPercent = 2;
                        elseif ($project->status->key == 'university')
                            $dataPercent = 3;
                        elseif ($project->status->key == 'published')
                            $dataPercent = 4;
                    }
                    ?>
                    <div class="ui progress" data-value="{{$dataPercent}}" data-total="4">
                        <div class="bar">
                        </div>
                        <div class="label">{{$project->status->name or ""}}</div>
                    </div>

                </td>
                <td class="center aligned collapsing">
                    <a href="/backend/admin/project/{{$project->id}}/edit" class="ui icon blue button">
                        <i class="edit icon"></i>
                    </a>
                </td>
                <td class="center aligned collapsing">


                    <form class="inline" id="frmdelete_{{$project->id}}" method="post"
                          action="/backend/admin/project/{{$project->id}}/delete">
                        {{csrf_field()}}


                        <button type="button" class="ui icon red  button deleteProjectBtn">
                            <i class="trash icon"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="6">
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
@endif

<script type="text/javascript">

    $(".deleteProjectBtn").on('click', function () {
        if (confirm('คุณต้องการลบโครงการนี้ ใช่หรือไม่')) {
            $(this).parent().submit();
        }
    })

    function askSubmitProject(id) {
        if (confirm('คุณต้องการส่งแบบโครงการนี้ ใช่หรือไม่')) {
            var frmid = "#frmSubmit_" + id;
            $(frmid).submit();
        }
    }

    $('.ui.progress').progress({
        total: 4
    });


</script>
