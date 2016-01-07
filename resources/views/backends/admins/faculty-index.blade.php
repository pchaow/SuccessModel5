@extends('backends.layout')

@section('content')

    <h2>จัดการรายการคณะ</h2>

    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="4">
                <a href="/backend/faculty/addForm" class="ui labeled icon button">
                    <i class="plus icon"></i>
                    เพิ่มรายการคณะ
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
            <th>ชื่อคณะภาษาไทย</th>
            <th>ชื่อคณะภาษาอังกฤษ</th>
            <th>การจัดการ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($faculties as $faculty)
            <tr>
                <td>{{$faculty->id}}</td>
                <td>{{$faculty->name_th}}</td>
                <td>{{$faculty->name_en}}</td>
                <td class="center aligned collapsing">


                    <form class="inline" id="frmdelete_{{$faculty->id}}" method="post"
                          action="/backend/faculty/{{$faculty->id}}/delete">
                        {{csrf_field()}}
                        <a href="/backend/faculty/{{$faculty->id}}/edit" class="ui icon blue button">
                            <i class="edit icon"></i>
                        </a>

                        <button type="button" class="ui icon red  button" onclick="askDeleteFaculty({{$faculty->id}});">
                            <i class="trash icon"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4">
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

        function askDeleteFaculty(id) {
            if (confirm('คุณต้องการลบคณะนี้ ใช่หรือไม่')) {
                var frmid = "#frmdelete_" + id;
                $(frmid).submit();
            }
        }


    </script>
@endsection
