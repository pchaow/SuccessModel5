@extends('backends.layout')

@section('javascript')

    <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=drawing&v=3.22&key=AIzaSyCyb1w6ezK3C0k64_1AiB0vK-qjmQkCrcI"></script>

    <style>
        #color-palette {
            clear: both;
        }

        .color-button {
            width: 14px;
            height: 14px;
            font-size: 0;
            margin: 2px;
            float: left;
            cursor: pointer;
        }
    </style>
    <script src="/bower/ckeditor/ckeditor.js"></script>

@endsection

@section('content')

    <h2>แก้ไขโครงการ</h2>


    @include('backends.project.form', [
        'action' => "/backend/project/$project->id/doEdit",
        'cancel' => '/backend/project',
        'type' => "EDIT",
        'step' => $step,
        "role" => "RESEARCHER"
        ])



@endsection
