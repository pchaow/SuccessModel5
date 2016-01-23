@extends('frontends.layout')

@section('javascript')

        <!-- Core JS file -->
<link rel="stylesheet" href="/bower/fancybox/source/jquery.fancybox.css" type="text/css" media="screen"/>
<script src="/bower/fancybox/source/jquery.fancybox.pack.js"></script>

<link rel="stylesheet" href="/bower/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css"
      media="screen"/>
<script type="text/javascript" src="/bower/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="/bower/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="/bower/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css"
      media="screen"/>
<script type="text/javascript" src="/bower/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

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

                        <h3 class="ui header">
                            คณะผู้วิจัย
                            <div class="sub header">
                                <div class="ui horizontal divided list">
                                    @foreach($project->users as $user)
                                        <div class="item">
                                            <div class="content">
                                                <div class="header">{{$user->title . $user->firstname . " " . $user->lastname}}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
                    <div class="ui secondary segment">
                        <div class="ui images">
                            @foreach($project->photos()->get() as $photo)
                                <a class="fancybox" rel="group"
                                   href="/project/{{$project->id}}/photos/{{$photo->filename}}">
                                    <img style="width: 95px;height:95px;" class="ui image"
                                         src="/project/{{$project->id}}/photos/{{$photo->filename}}?w=300&h=300&fit=crop">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="ui segments">
                    <div class="ui segment">
                        <h3>วิดิโอ</h3>
                    </div>
                    <div class="ui secondary segment">
                        <div class="ui tiny images">
                            @foreach($project->youtubes as $youtube)
                                <a class="fancybox-media"
                                   href="http://www.youtube.com/watch?v={{$youtube->youtube_id}}">
                                    <img style="width: 95px;height:95px;" class="ui image"
                                         src="http://img.youtube.com/vi/{{$youtube->youtube_id}}/hqdefault.jpg">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $(".fancybox").fancybox();

            $('.fancybox-media').fancybox({
                openEffect: 'none',
                closeEffect: 'none',
                helpers: {
                    media: {}
                }
            });

            $('.ui.embed').embed();

        });
    </script>

@endsection
