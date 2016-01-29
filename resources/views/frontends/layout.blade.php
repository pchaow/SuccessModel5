@extends('frontends.master')

@section('layout')

    <div class="ui  menu">
        <a class="active item">
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
                    <div class="item">{{$faculty->name_th}}</div>
                @endforeach

            </div>
        </div>

    </div>

    <div class="sixteen wide column">

        @yield('content')


    </div>
@endsection