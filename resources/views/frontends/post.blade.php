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

<script src="https://maps.google.com/maps/api/js?sensor=false&libraries=drawing&v=3.22&key=AIzaSyCyb1w6ezK3C0k64_1AiB0vK-qjmQkCrcI"></script>
@endsection

@section('content')

    <div class="sixteen wide column">
        <div class="ui vertically divided grid">
            <div class="row">
                <div class="sixteen wide column">
                    <div class="ui huge header" style="margin: 0px;">{{$post->title}}
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="sixteen wide column">
                    <a class="fancybox" rel="group"
                       href="/post/{{$post->id}}/cover/{{$post->cover_file}}">
                        <img class="ui image"
                             src="/post/{{$post->id}}/cover/{{$post->cover_file}}?w=577&h=300&fit=crop"/>
                    </a>
                </div>

                <div class="eleven wide column">
                    {!! $post->content !!}
                </div>
                <div class="five wide column">
                    <div class="ui segments">
                        <div class="ui segment">
                            <h3>ภาพประกอบข่าว</h3>
                        </div>
                        <div class="ui secondary segment">
                            <div class="ui images">
                                @foreach($post->photos()->get() as $photo)
                                    <a class="fancybox" rel="group"
                                       href="/post/{{$post->id}}/photos/{{$photo->filename}}">
                                        <img style="width: 95px;height:95px;" class="ui image"
                                             src="/post/{{$post->id}}/photos/{{$photo->filename}}?w=300&h=300&fit=crop">
                                    </a>
                                @endforeach
                            </div>
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
            $('#closeWindowBtn').on('click', function () {
                var win = window.opener;
                win.reload();
                window.close();
            });

        });
    </script>

@endsection
