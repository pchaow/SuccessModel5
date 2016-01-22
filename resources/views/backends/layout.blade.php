@extends('backends.master')

@section('layout')
    <div class="ui grid">
        <!--div class="sixteen wide column">
            <div class="ui menu">
                <a class="active item">
                    Home
                </a>
                <a class="item">
                    Messages
                </a>
                <a class="item">
                    Friends
                </a>
                <div class="right menu">
                    <div class="item">
                        <div class="ui transparent icon input">
                            <input type="text" placeholder="Search...">
                            <i class="search link icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div-->
        <div class="four wide column">

            <div class="ui fluid vertical menu">
                <a href="/backend/" class="{{ Request::is('backend') ? 'active' : ''   }}  teal item">
                    หน้าหลัก
                </a>
                <div class="item">
                    <?php
                    $user = Auth::user();
                    ?>
                    <div class="header">
                        {{$user->title}}{{$user->firstname}} {{$user->lastname}}
                    </div>

                    <div class="menu">
                        <a href="/backend/change-profile"
                           class="{{ Request::is('backend/change-profile') || Request::is('backend/change-profile/*') ? 'active' : ''   }} teal item">
                            แก้ไขข้อมูลส่วนตัว
                        </a>
                        <a href="/backend/logout" class="item">ออกจากระบบ</a>
                    </div>
                </div>
                @if($user->is("researcher"))
                    <div class="item">
                        <div class="header">นักวิจัย</div>
                        <div class="menu">
                            <a href="/backend/project"
                               class="{{ Request::is('backend/project') || Request::is('backend/project/*') ? 'active' : ''   }} teal item">
                                รายการโครงการ
                            </a>
                            <a class="item">Consumer</a>
                        </div>
                    </div>
                @endif
                @if($user->is("faculty"))
                    <div class="item">
                        <div class="header">ผู้ประสานงานระดับคณะ</div>
                        <div class="menu">
                            <a class="item">พิจารณาโครงการ</a>

                        </div>
                    </div>
                @endif
                @if($user->is("university"))
                    <div class="item">
                        <div class="header">ผู้ประสานงานศูนย์ ABC</div>
                        <div class="menu">
                            <a class="item">พิจารณาโครงการ</a>
                        </div>
                    </div>
                @endif
                @if($user->is("admin"))
                    <div class="item">
                        <div class="header">ผู้ดูแลระบบ</div>
                        <div class="fluid menu">
                            <a href="/backend/user"
                               class="{{ Request::is('backend/user') || Request::is('backend/user/*') ? 'active' : ''   }} teal item">
                                รายการผู้ใช้
                            </a>
                            <a href="/backend/admin/project"
                               class="{{ Request::is('backend/admin/project') || Request::is('backend/admin/project/*') ? 'active' : ''   }} teal item">
                                รายการโครงการ
                            </a>
                            <a href="/backend/faculty"
                               class="{{ Request::is('backend/faculty') || Request::is('backend/faculty/*') ? 'active' : ''   }} teal item">
                                รายการคณะ
                            </a>
                            <a href="/backend/role"
                               class="{{ Request::is('backend/role') || Request::is('backend/role/*') ? 'active' : ''   }} teal item">
                                รายการสิทธิ์
                            </a>
                            <a href="/backend/project-status"
                               class="{{ Request::is('backend/project-status') || Request::is('backend/project-status/*') ? 'active' : ''   }} teal item">
                                รายการสถานะโครงการ
                            </a>
                            <a class="item">FAQs</a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <div class="twelve wide column">

            @yield('content')

        </div>
    </div>
@endsection