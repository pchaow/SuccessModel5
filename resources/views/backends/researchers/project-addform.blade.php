@extends('backends.layout')

@section('content')

    <h2>เพิ่มโครงการ</h2>


    @include('backends.researchers.project-form', [
        'action' => '/backend/projects/doAdd',
        'cancel' => '/backend/projects',
        'type' => "ADD"
        ])

    <script>
        $('.menu .item')
                .tab()
        ;

        $('form .dropdown')
                .dropdown({})
        ;
    </script>



@endsection
