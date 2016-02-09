@extends('backends.layout')

@section('content')

    <h2>แก้ไขข้อมูลส่วนตัว</h2>

    <form class="ui form" action="/backend/profile" method="post">
        {{csrf_field()}}
        <div class="three fields">
            <div class="field">
                <label>คำนำหน้า</label>
                <input type="text" name="user[title]" placeholder="คำนำหน้า" value="{{$user->title}}">
            </div>
            <div class="field">
                <label>ชื่อ</label>
                <input type="text" name="user[firstname]" placeholder="ชื่อ" value="{{$user->firstname}}">
            </div>

            <div class="field">
                <label>นามสกุล</label>
                <input type="text" name="user[lastname]" placeholder="นามสกุล" value="{{$user->lastname}}">
            </div>
        </div>

        <div class="three fields">
            <div class="field">
                <label>E-Mail</label>
                <input type="email" name="user[email]" placeholder="E-Mail" value="{{$user->email}}">
            </div>

            <div class="field">
                <label>ชื่อผู้ใช้</label>
                <input type="text" name="user[username]" placeholder="ชื่อผู้ใช้" value="{{$user->username}}">
            </div>

            <div class="field">
                <label>รหัสผ่าน</label>
                <input type="password" name="user[password]" placeholder="รหัสผ่าน" value="{{$user->password}}">
            </div>
        </div>

        <div class="field">
            <label>กอง/คณะ/วิทยาลัย</label>
            <div class="ui disabled selection dropdown" tabindex="0">
                <input type="hidden" name="user[faculty_id]" value="{{$user->faculty_id}}">
                @if($user->faculty_id)
                    <div class="text">{{$user->faculty->name_th}}</div>
                @else
                    <div class="default text">กรุณาเลือก</div>
                @endif
                <i class="dropdown icon"></i>
                <div class="menu transition hidden" tabindex="-1">
                    <?php
                    $faculties = \App\Models\Faculty::all();
                    ?>
                    @foreach($faculties as $faculty)
                        <div class="item {{ $user->faculty_id == $faculty->id ? "active" : ""  }}"
                             data-value="{{$faculty->id}}">
                            {{$faculty->name_th}}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="field">
            <button class="ui button" type="submit">ตกลง</button>
            <a class="ui red button" href="/backend">ยกเลิก</a>
        </div>

        <script>
            $('.menu .item').tab({});

            $('form .dropdown')
                    .dropdown({})
            ;
        </script>

    </form>


@endsection
