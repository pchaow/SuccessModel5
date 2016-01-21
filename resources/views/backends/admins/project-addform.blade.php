@extends('backends.layout')

@section('content')

    <h2>เพิ่มโครงการ</h2>


    @include('backends.admins.project-form', [
        'action' => '/backend/admin/project/doAdd',
        'cancel' => '/backend/admin/project',
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

@section('javascript')
    <script src="/bower/ckeditor/ckeditor.js"></script>
@endsection