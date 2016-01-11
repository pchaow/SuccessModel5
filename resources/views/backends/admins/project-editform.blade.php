@extends('backends.layout')

@section('javascript')
    <link rel="stylesheet" href="{{asset("openlayers/ol.css")}}" type="text/css">
    <script src="{{ asset("openlayers/ol-debug.js") }}"></script>

@endsection

@section('content')

    <h2>แก้ไขโครงการ</h2>


    @include('backends.admins.project-form', [
        'action' => "/backend/admin/project/$project->id/doEdit",
        'cancel' => '/backend/admin/project',
        'type' => "EDIT",
        'step' => $step
        ])



@endsection
