@extends('backends.project.layout')

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

    <div class="ui  menu">
        <a class="item" id="closeWindowBtn">
            ปิดหน้าต่างนี้
        </a>
        @if($previewRole == 'previewOnly')

        @elseif($previewRole != 'researcher')
            <div class="item">
                <button id="acceptProjectBtn" type="button" class="ui blue button" data-id="{{$project->id}}"
                        data-role="{{$previewRole}}">
                    ยอมรับโครงการ
                </button>
            </div>

            <div class="item">
                <button id="rejectProjectBtn" type="button" class="ui red button" data-id="{{$project->id}}"
                        data-role="{{$previewRole}}">
                    ปฏิเสธโครงการ
                </button>
            </div>
        @else
            <div class="item">
                <button id="acceptProjectBtn" type="button" class="ui blue button" data-id="{{$project->id}}"
                        data-role="{{$previewRole}}">
                    ส่งโครงการ
                </button>
            </div>
        @endif
    </div>

    <div class="sixteen wide column">
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
                    <div class="ui segments">
                        <input type="hidden" name="project[geojson]" id="geojson-input" value="{{$project->geojson}}"/>

                        <div class="ui segment">
                            <h3>พื้นที่ที่ดำเนินโครงการ</h3>
                        </div>
                        <div class="ui secondary segment" id="gmap" style="height: 330px;">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <div id="acceptModal" class="ui modal">
        <i class="close icon"></i>
        <div class="header">
            ยอมรับโครงการ
        </div>
        <div class="content">
            <form id="acceptForm" class="ui form">
                <div class="field">
                    <label>ความคิดเห็น/รายละเอียด</label>
                    <textarea name="acceptForm[comment]"></textarea>
                </div>
            </form>
        </div>
        <div class="actions">
            <div id="acceptModalOkBtn" class="ui blue button" data-id="{{$project->id}}" data-role="{{$previewRole}}">
                ตกลง
            </div>
            <div id="acceptModalCancelBtn" class="ui button">ยกเลิก</div>
        </div>
    </div>

    <div id="rejectModal" class="ui modal">
        <i class="close icon"></i>
        <div class="header">
            ปฏิเสธโครงการ
        </div>
        <div class="content">
            <form id="rejectForm" class="ui form">
                <div class="field">
                    <label>ความคิดเห็น/รายละเอียด</label>
                    <textarea name="acceptForm[comment]"></textarea>
                </div>
            </form>
        </div>
        <div class="actions">
            <div id="rejectModalOkBtn" class="ui blue button" data-id="{{$project->id}}" data-role="{{$previewRole}}">
                ตกลง
            </div>
            <div id="rejectModalCancelBtn" class="ui button">ยกเลิก</div>
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

            $('#acceptModal').modal();
            $('#rejectModal').modal();


            $('.ui.embed').embed();
            $('#closeWindowBtn').on('click', function () {
                var win = window.opener;
                win.reload();
                window.close();
            });

            $('#acceptProjectBtn').on('click', function () {
                $("#acceptModal").modal('show');
            });

            $('#rejectProjectBtn').on('click', function () {
                $("#rejectModal").modal('show');
            });

            $("#acceptModalOkBtn").on('click', function () {
                var projectId = $(this).attr('data-id');
                var previewRole = $(this).attr('data-role');

                $.post("/backend/" + previewRole + "-project/" + projectId + "/doAccept"
                        , $("#acceptForm").serialize()
                        , function (response) {
                            var win = window.opener;
                            win.reload();
                            window.close();
                        })

            });

            $("#acceptModalCancelBtn").on('click', function () {
                $("#acceptModal").modal('hide');

            });

            $("#rejectModalOkBtn").on('click', function () {
                var projectId = $(this).attr('data-id');
                var previewRole = $(this).attr('data-role');

                $.post("/backend/" + previewRole + "-project/" + projectId + "/doReject"
                        , $("#rejectForm").serialize()
                        , function (response) {
                            var win = window.opener;
                            win.reload();
                            window.close();
                        })

            });


            $("#rejectModalCancelBtn").on('click', function () {
                $("#rejectModal").modal('hide');

            });

            var map;
            var geoJsonInput = document.getElementById('geojson-input');

            function refreshGeoJsonFromData() {
                map.data.toGeoJson(function (geoJson) {
                    geoJsonInput.value = JSON.stringify(geoJson, null, 2);
                });
            }

            function bindDataLayerListeners(dataLayer) {
                dataLayer.addListener('addfeature', refreshGeoJsonFromData);
                dataLayer.addListener('removefeature', refreshGeoJsonFromData);
                dataLayer.addListener('setgeometry', refreshGeoJsonFromData);
            }

            function loadJsonFromString() {
                if (geoJsonInput.value) {
                    var geojson = JSON.parse(geoJsonInput.value);
                    map.data.addGeoJson(geojson);
                    zoom(map);

                    setTimeout(function () {
                        map.setZoom(10);
                    }, 300)
                }
            }

            function processPoints(geometry, callback, thisArg) {
                if (geometry instanceof google.maps.LatLng) {
                    callback.call(thisArg, geometry);
                } else if (geometry instanceof google.maps.Data.Point) {
                    callback.call(thisArg, geometry.get());
                } else {
                    geometry.getArray().forEach(function (g) {
                        processPoints(g, callback, thisArg);
                    });
                }
            }

            function zoom(map) {
                var bounds = new google.maps.LatLngBounds();
                var count = 0;
                map.data.forEach(function (feature) {
                    count++;
                    processPoints(feature.getGeometry(), bounds.extend, bounds);
                });
                if (count > 0) {
                    map.fitBounds(bounds);
                }
            }

            function initialize() {

                map = new google.maps.Map(document.getElementById('gmap'), {
                    center: new google.maps.LatLng(19.2178981, 100.1890168),
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoomControl: true
                });

                loadJsonFromString();

                bindDataLayerListeners(map.data);

            }

            initialize();
        });
    </script>

@endsection
