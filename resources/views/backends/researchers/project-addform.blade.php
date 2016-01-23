@extends('backends.layout')

@section('javascript')
    <script src="/bower/ckeditor/ckeditor.js"></script>
@endsection

@section('content')

    <h2>เพิ่มโครงการ</h2>


    @include('backends.project.form', [
        'action' => '/backend/project/doAdd',
        'cancel' => '/backend/project',
        'type' => "ADD",
        'role' => 'RESEARCHER'
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
