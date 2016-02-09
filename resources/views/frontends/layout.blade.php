@extends('frontends.master')

@section('layout')

    <div class="ui  menu">
        <a class="active item" href="/">
            หนัาหลัก
        </a>
        <div class="ui simple dropdown item">
            หน่วยงานที่ทำวิจัย
            <i class="dropdown icon"></i>
            <div class="menu">
                <?php
                $faculties = \App\Models\Faculty::all();
                ?>
                @foreach($faculties as $faculty)
                    <a class="link item" href="/project?faculty_id={{$faculty->id}}">{{$faculty->name_th}}</a>
                @endforeach

            </div>
        </div>

    </div>

    <div class="sixteen wide column">

        @yield('content')


    </div>
@endsection