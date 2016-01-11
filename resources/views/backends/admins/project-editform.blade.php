@extends('backends.layout')

@section('content')

    <h2>แก้ไขโครงการ</h2>


    @include('backends.admins.project-form', [
        'action' => "/backend/admin/project/$project->id/doEdit",
        'cancel' => '/backend/admin/project',
        'type' => "EDIT",
        'step' => $step
        ])

    <script>
        $('.menu .item').tab({
            {{--history : true,--}}
            {{--historyType: 'state',--}}
            {{--path: '/backend/admin/project/{{$project->id}}/edit/'--}}

        });

        $('.menu .item').tab('change tab', "{{$step}}")


        $('form .dropdown')
                .dropdown({})
        ;
    </script>



@endsection
