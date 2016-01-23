@extends('backends.layout')

@section('content')

    <h2>เพิ่มโครงการ</h2>


    @include('backends.project.form', [
        'action' => '/backend/admin/project/doAdd',
        'cancel' => '/backend/admin/project',
        'type' => "ADD",
        'role' => "ADMIN"
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

@section('javascript')
    <script src="/bower/ckeditor/ckeditor.js"></script>
@endsection