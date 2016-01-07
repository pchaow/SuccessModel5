@extends('backends.master')

@section('layout')
    <div class="ui grid">
        <div class="sixteen wide column">
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


        </div>
        <div class="four wide column">

            <div class="ui fluid vertical menu">
                <a href="/backend/" class="{{ Request::is('backend') ? 'active' : ''   }}  teal item">
                    หน้าหลัก
                </a>
                <div class="item">
                    <div class="header">นักวิจัย</div>
                    <div class="menu">
                        <a class="item">Enterprise</a>
                        <a class="item">Consumer</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">ผู้ประสานงานระดับคณะ</div>
                    <div class="menu">
                        <a class="item">Rails</a>
                        <a class="item">Python</a>
                        <a class="item">PHP</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">ผู้ประสานงาน DREQA</div>
                    <div class="menu">
                        <a class="item">Shared</a>
                        <a class="item">Dedicated</a>
                    </div>
                </div>
                <div class="item">
                    <div class="header">ผู้ดูแลระบบ</div>
                    <div class="fluid menu">
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
            </div>

        </div>
        <div class="twelve wide column">

            @yield('content')

        </div>
    </div>
@endsection