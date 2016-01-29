@extends('backends.layout')

@section('javascript')
    <script src="/bower/ckeditor/ckeditor.js"></script>
@endsection

@section('content')

    <h2>เพิ่มข่าวประกาศ</h2>


    @include('backends.posts.form', [
        'action' => "/backend/post/$post->id/doEdit",
        'cancel' => '/backend/post',
        'type' => "EDIT",
        'role' => 'ADMIN'
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
