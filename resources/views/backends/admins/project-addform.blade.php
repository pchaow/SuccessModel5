@extends('backends.layout')

@section('content')

    <h2>เพิ่มรายการโครงการ</h2>
    <form class="ui form" action="/backend/admin/project/doAdd" method="post">
        {{csrf_field()}}
        <div class="ui pointing secondary menu">
            <a class="item active" data-tab="first">ข้อมูลเบื้องต้น</a>
            <a class="item" data-tab="second">Second</a>
            <a class="item" data-tab="third">Third</a>
        </div>

        <div class="ui bottom attached tab active" data-tab="first">

            <div class="field">
                <label>กอง/คณะ/วิทยาลัย</label>
                <div class="ui selection dropdown" tabindex="0">
                    <input type="hidden" name="project[faculty][id]">
                    <div class="default text">กรุณาเลือก</div>
                    <i class="dropdown icon"></i>
                    <div class="menu transition hidden" tabindex="-1">
                        <?php
                        $faculties = \App\Models\Faculty::all();
                        ?>
                        @foreach($faculties as $faculty)
                            <div class="item" data-value="{{$faculty->id}}">
                                {{$faculty->name_th}}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="field">
                <label>ชื่อโครงการภาษาไทย</label>
                <input type="text" name="project[name_th]" placeholder="ชื่อโครงการภาษาไทย">
            </div>
            <div class="field">
                <label>ชื่อโครงการภาษาอังกฤษ</label>
                <input type="text" name="project[name_en]" placeholder="ชื่อโครงการภาษาอังกฤษ">
            </div>

            <div class="field">
                <label>รายละเอียดโครงการ ภาษาไทย</label>
                <textarea rows="10"></textarea>
            </div>

            <div class="field">
                <label>รายละเอียดโครงการ ภาษาอังกฤษ(ถ้ามี)</label>
                <textarea rows="10"></textarea>
            </div>

            <button class="ui button" tabindex="0">เพิ่มโครงการ</button>

        </div>

        <div class="ui bottom attached tab " data-tab="second">
            Second
        </div>

        <div class="ui bottom attached tab " data-tab="third">
            Third
        </div>


    </form>

    <script>
        $('.menu .item')
                .tab()
        ;

        $('form .dropdown')
                .dropdown({})
        ;
    </script>



@endsection
