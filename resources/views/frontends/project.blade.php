@extends('frontends.layout')

@section('javascript')

        <!-- Core JS file -->
<link rel="stylesheet" href="/bower/fancybox/source/jquery.fancybox.css" type="text/css" media="screen"/>
<script src="/bower/fancybox/source/jquery.fancybox.pack.js"></script>


@endsection

@section('content')

    <div class="ui vertically divided grid">
        <div class="row">

            <div class="sixteen wide column">
                <div class="ui grid">
                    <div class="eight wide column">
                        <a class="fancybox" rel="group"
                           href="/project/{{$project->id}}/cover/{{$project->cover_file}}">
                            <img class="ui image"
                                 src="/project/{{$project->id}}/cover/{{$project->cover_file}}?w=577&h=300&fit=crop"/>
                        </a>
                    </div>
                    <div class="eight wide column">
                        <div class="ui huge header" style="margin: 0px;">{{$project->name_th}}
                            <div class="sub header"> ดำเนินงานโดย {{$project->faculty->name_th}}</div>

                        </div>
                        <h3 class="ui header">
                            สถานที่ดำเนินโครงการ
                            <div class="sub header"> {{$project->location or ""}} {{$project->district->DISTRICT_NAME or ""}} {{$project->amphur->AMPHUR_NAME or ""}} {{$project->province->PROVINCE_NAME or ""}}</div>

                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="eleven wide column">
                {!! $project->description_th !!}

                {!! $project->description_en !!}
            </div>
            <div class="five wide column">
                <div class="ui segments">
                    <div class="ui segment">
                        <h3>รูปภาพ</h3>
                    </div>
                    <div class="ui secondary center aligned segment">
                        <div class="ui tiny images">
                            @foreach($project->photos as $photo)
                                <a class="fancybox" rel="group"
                                   href="/project/{{$project->id}}/photos/{{$photo->filename}}">
                                    <img class="ui image"
                                         src="/project/{{$project->id}}/photos/{{$photo->filename}}?w=300&h=300&fit=crop">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="sixteen wide column">
                Youtube
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".fancybox").fancybox();
        });
    </script>

@endsection
