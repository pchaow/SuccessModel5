<div class="ui pointing secondary menu">
    <a class="item active" data-tab="first">ข้อมูลเบื้องต้น</a>
    @if($type=="EDIT")
        <a class="item" data-tab="second">ภาพปก</a>
        <a class="item" data-tab="third">รูปภาพ</a>
        <a class="item" data-tab="forth">Youtube</a>
        <a class="item" data-tab="fifth">นักวิจัยในโครงการ</a>
        <a class="item" data-tab="sixth">แผนที่แสดงตำแหน่งที่ดำเนินโครงการ </a>
    @endif
</div>

<div class="ui bottom attached tab active" data-tab="first">
    <form class="ui form" action="{{$action}}" method="post">
        {{csrf_field()}}

        <h4 class="ui dividing header">ข้อมูลพื้นฐาน</h4>

        <div class="field">
            <label>ชื่อโครงการภาษาไทย</label>
            <input type="text" name="project[name_th]" placeholder="ชื่อโครงการภาษาไทย" value="{{$project->name_th}}">
        </div>
        <div class="field">
            <label>ชื่อโครงการภาษาอังกฤษ</label>
            <input type="text" name="project[name_en]" placeholder="ชื่อโครงการภาษาอังกฤษ"
                   value="{{$project->name_en}}">
        </div>

        <div class="field">
            <label>กอง/คณะ/วิทยาลัย ที่ดำเนินโครงการ</label>
            <div class="ui selection dropdown" tabindex="0">
                <input type="hidden" name="project[faculty][id]" value="{{$project->faculty_id}}">
                @if($project->faculty_id)
                    <div class="text">{{$project->faculty->name_th}}</div>
                @else
                    <div class="default text">กรุณาเลือก</div>
                @endif
                <i class="dropdown icon"></i>
                <div class="menu transition hidden" tabindex="-1">
                    <?php
                    $faculties = \App\Models\Faculty::all();
                    ?>
                    @foreach($faculties as $faculty)
                        <div class="item {{ $project->faculty_id == $faculty->id ? "active" : ""  }}"
                             data-value="{{$faculty->id}}">
                            {{$faculty->name_th}}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <h4 class="ui dividing header">สถานที่ดำเนินโครงการ</h4>
        <div class="field">
            <label>ชื่อสถานที่</label>
            <input type="text" name="project[location]" placeholder="สถานที่ดำเนินโครงการ"
                   value="{{$project->location}}">
        </div>

        <div class="three fields">
            <div class="field">
                <label>จังหวัด</label>
                <div id="map_dropdown_province" class="ui fluid selection dropdown">
                    <input type="hidden" name="project[province_id]">
                    <i class="dropdown icon"></i>
                    <div class="default text">เลือกจังหวัด</div>

                    <div class="menu">
                        <?php
                        $provinces = \App\Models\Thailand\Province::all();
                        ?>
                        @foreach($provinces as $province)
                            <div class="item" data-value="{{$province->PROVINCE_ID}}">
                                {{$province->PROVINCE_NAME}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="field">
                <label>อำเภอ</label>
                <div id="map_dropdown_amphur" class="ui fluid selection dropdown">
                    <input type="hidden" name="project[amphur_id]">
                    <i class="dropdown icon"></i>
                    <div class="default text">เลือกอำเภอ</div>
                    <div class="menu"></div>
                </div>
            </div>
            <div class="field">
                <label>ตำบล</label>
                <div id="map_dropdown_district" class="ui fluid selection dropdown">
                    <input type="hidden" name="project[district_id]">
                    <i class="dropdown icon"></i>
                    <div class="default text">เลือกตำบล</div>
                    <div class="menu"></div>
                </div>
            </div>
        </div>

        <h4 class="ui dividing header">รายละเอียดโครงการ</h4>

        <div class="field">
            <label>รายละเอียดโครงการ ภาษาไทย</label>
            <textarea name="project[description_th]" rows="10">{{$project->description_th}}</textarea>
        </div>

        <div class="field">
            <label>รายละเอียดโครงการ ภาษาอังกฤษ(ถ้ามี)</label>
            <textarea name="project[description_en]" rows="10">{{$project->description_en}}</textarea>
        </div>

        <h4 class="ui dividing header">ข้อมูลอื่นๆ สำหรับผู้ดูแลระบบ</h4>

        <div class="field">
            <label>สถานะโครงการ</label>
            <div class="ui selection dropdown" tabindex="0">
                <input type="hidden" name="project[status][id]" value="{{$project->status_id}}">
                @if($project->status_id)
                    <div class="text">{{$project->status->name}}</div>
                @else
                    <div class="default text">กรุณาเลือก</div>
                @endif
                <i class="dropdown icon"></i>
                <div class="menu transition hidden" tabindex="-1">
                    <?php
                    $statuses = \App\Models\ProjectStatus::all();
                    ?>
                    @foreach($statuses as $status)
                        <div class="item {{ $project->status_id == $status->id ? "active" : ""  }}"
                             data-value="{{$status->id}}">
                            {{$status->name}}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        @if($type == "ADD")
            <button class="ui button" tabindex="0">เพิ่มโครงการ</button>
        @else
            <button class="ui button" tabindex="0">แก้ไขโครงการ</button>
        @endif

        <a href="{{$cancel}}" class="ui red button" tabindex="0">ยกเลิก</a>

    </form>

    <script>
        $(document).ready(function () {
            var provinceDropdown = $("#map_dropdown_province");
            var amphurDropdown = $("#map_dropdown_amphur");
            var districtDropdown = $("#map_dropdown_district");
            var provinceId = 0;
            var amphurId = 0;

            amphurDropdown.addClass("disabled");
            districtDropdown.addClass("disabled");


            provinceDropdown.on('change', function (el) {
                provinceId = provinceDropdown.dropdown('get value')

                amphurDropdown.addClass("disabled");
                districtDropdown.addClass("disabled");

                amphurDropdown.dropdown('clear');
                districtDropdown.dropdown('clear');


                $.getJSON("/api/province/" + provinceId + "/amphur", function (response) {
                    console.log(response);
                    $("#map_dropdown_amphur > .menu").html("");
                    numAmphur = response.length;
                    for (i = 0; i < numAmphur; i++) {
                        $("#map_dropdown_amphur > .menu").append('<div class="item" data-value="' + response[i].AMPHUR_ID + '">' + response[i].AMPHUR_NAME + '</div>');
                    }
                    amphurDropdown.removeClass('disabled');
                    districtDropdown.addClass("disabled");


                });
            })

            amphurDropdown.on('change', function (el) {

                districtDropdown.addClass("disabled");
                districtDropdown.dropdown('clear');


                amphurId = amphurDropdown.dropdown('get value');
                if (amphurId) {
                    $.getJSON("/api/province/" + provinceId + "/amphur/" + amphurId + "/district", function (response) {
                        console.log(response);
                        $("#map_dropdown_district > .menu").html("");
                        numAmphur = response.length;
                        for (i = 0; i < numAmphur; i++) {
                            $("#map_dropdown_district > .menu").append('<div class="item" data-value="' + response[i].DISTRICT_ID + '">' + response[i].DISTRICT_NAME + '</div>');
                        }
                        districtDropdown.dropdown('clear');
                        districtDropdown.removeClass('disabled');


                    });
                }

            })
        })
    </script>

</div>

<div class="ui bottom attached tab " data-tab="second">
    <form class="ui form" method="post" action="/backend/admin/project/{{$project->id}}/doSaveCover"
          enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="field">
            <label>ภาพปก</label>
            <button id="coverUploadBtn" type="button" class="ui blue button" tabindex="0">เลือกไฟล์</button>
            <span id="filename"></span>

            <div style="width:0px;height: 0px;overflow: hidden;">
                <input id="coverInput" type="file" name="project[cover_upload]">
            </div>
        </div>

        <div class="field">
            @if($project->cover_file)
                <img id="previewImage" height="200"
                     src="/backend/admin/project/{{$project->id}}/getCover/{{$project->cover_file}}?h=200"
                     alt="Image preview...">
            @else
                <img id="previewImage" src="" alt="Image preview...">
            @endif

        </div>

        <button disabled="disabled" id="confirmUpload" class="ui button" tabindex="0">ยืนยัน</button>
        <a href="{{$cancel}}" class="ui red button" tabindex="0">ยกเลิก</a>

        <script>
            $("#coverUploadBtn").on("click", function () {
                $("#coverInput").click();
            })

            function previewFile(evt) {
                var preview = $("#previewImage");
                var files = evt.target.files;
                var file = files[0];
                $("#filename").html(file.name)
                var reader = new FileReader();

                reader.onloadend = function () {
                    preview.attr("src", reader.result);
                    preview.attr("height", 200);
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                }

                $("#confirmUpload").removeAttr('disabled');

            }

            $("#coverInput").on("change", previewFile);

        </script>
    </form>
</div>

<div class="ui bottom attached tab " data-tab="third">

    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="4">
                <form class="ui form" method="post" enctype="multipart/form-data"
                      action="/backend/admin/project/{{$project->id}}/doUploadPhoto">
                    {{csrf_field()}}
                    <div class="field">
                        <button id="photoUploadBtn" type="button" class="ui labeled icon button">
                            <i class="plus icon"></i>
                            อัพโหลดรูป
                        </button>

                        <span id="photoUploadFilename"></span>
                    </div>

                    <div class="two fields photoUploadPreview" style="display:none">
                        <div class="field">
                            <label>ตัวอย่างรูป</label>
                            <img id="previewUploadPhoto" src="" alt="Image preview...">
                        </div>
                        <div class="field">
                            <label>คำอธิบายรูป</label>
                            <textarea name="photo[description]" style="height: 200px;"></textarea>
                        </div>
                    </div>

                    <div class="field photoUploadPreview" style="display:none">
                        <button disabled="disabled" id="confirmPhotoUpload" class="ui button" tabindex="0">ยืนยัน
                        </button>
                        <a href="{{$cancel}}" class="ui red button" tabindex="0">ยกเลิก</a>

                    </div>

                    <div style="width:0px;height: 0px;overflow: hidden;">
                        <input id="photoInput" type="file" name="photo[file]">
                    </div>
                </form>
            </th>
        </tr>
        <tr>
            <th>ลำดับ</th>
            <th class="collapsing">รูปภาพ</th>
            <th>คำอธิบายภาพ</th>
            <th>การจัดการ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->photos as $photo)
            <tr>
                <td class="center aligned collapsing">{{$photo->id}}</td>
                <td class="collapsing">
                    <img id="previewImage" height="200"
                         src="/backend/admin/project/{{$project->id}}/photos/{{$photo->filename}}?h=200"
                         alt="Image preview...">
                </td>
                <td class="">

                    <div id="description_{{$photo->id}}">
                        {{$photo->description or "" }}
                    </div>

                    <form id="descriptionFrm_{{$photo->id}}" class="ui form" style="display:none;" method="post"
                          action="/backend/admin/project/{{$project->id}}/photo/{{$photo->id}}/doEditPhoto">
                        {{csrf_field()}}
                        <div class="field">
                            <textarea name="photo[description]">{{$photo->description}}</textarea>
                        </div>
                        <div class="field">
                            <button type="submit" class="ui button">บันทึก</button>
                            <button type="button" class="ui red button" onclick="showEditForm({{$photo->id}},false)">
                                ยกเลิก
                            </button>

                        </div>
                    </form>

                </td>
                <td class="center aligned collapsing">
                    <form class="inline" id="frmDeletePhoto_{{$photo->id}}" method="post"
                          action="/backend/admin/project/{{$project->id}}/photo/{{$photo->id}}/delete">
                        {{csrf_field()}}

                        <button type="button" class="ui blue icon button" onclick="showEditForm({{$photo->id}},true)">
                            <i class="edit icon"></i>
                        </button>

                        <button type="button" class="ui icon red  button" onclick="askDeletePhoto({{$photo->id}});">
                            <i class="trash icon"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4">
                <div class="ui right floated pagination menu">
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="item">1</a>
                    <a class="item">2</a>
                    <a class="item">3</a>
                    <a class="item">4</a>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>


    <script>
        $("#photoUploadBtn").on("click", function () {
            $("#photoInput").click();
        })

        function previewUploadPhoto(evt) {
            var preview = $("#previewUploadPhoto");
            var files = evt.target.files;
            var file = files[0];
            $("#photoUploadFilename").html(file.name)
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.attr("src", reader.result);
                preview.attr("height", 200);
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }

            $("#confirmPhotoUpload").removeAttr('disabled');

            $(".photoUploadPreview").show();

        }

        $("#photoInput").on("change", previewUploadPhoto);

        function askDeletePhoto(id) {
            if (confirm('คุณต้องการลบภาพนี้ ใช่หรือไม่')) {
                var frmid = "#frmDeletePhoto_" + id;
                $(frmid).submit();
            }
        }

        function showEditForm(id, display) {
            if (display == true) {
                $("#description_" + id).hide();
                $("#descriptionFrm_" + id).show();
            } else {
                $("#description_" + id).show();
                $("#descriptionFrm_" + id).hide();

            }

        }


    </script>
</div>

<div class="ui bottom attached tab" data-tab="forth">
    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="4">
                <form class="ui form" method="post"
                      action="/backend/admin/project/{{$project->id}}/doAddYoutube">
                    {{csrf_field()}}
                    <div class="fields">
                        <div class="thirteen wide field">
                            <label>Youtube URL</label>
                            <input type="text" name="youtube[url]"/>
                        </div>
                        <div class="three wide field">
                            <label>&nbsp;</label>
                            <button id="youtubeAddBtn" type="submit" class="ui labeled icon button">
                                <i class="plus icon"></i>
                                เพิ่ม
                            </button>
                        </div>
                    </div>

                </form>
            </th>
        </tr>
        <tr>
            <th>ลำดับ</th>
            <th class="collapsing">Youtube</th>
            <th>รายละเอียด</th>
            <th>การจัดการ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->youtubes as $youtube)
            <tr>
                <td class="center aligned collapsing">{{$youtube->id}}</td>
                <td class="collapsing">
                    {!! $youtube->embedHtml !!}
                </td>
                <td class="">
                    <b>{{$youtube->title}}</b><br/>
                    {{str_limit($youtube->description, $limit = 150, $end = '...') }}
                </td>
                <td class="center aligned collapsing">
                    <form class="inline" id="frmDeleteYoutube_{{$youtube->id}}" method="post"
                          action="/backend/admin/project/{{$project->id}}/youtube/{{$youtube->id}}/delete">
                        {{csrf_field()}}

                        <button type="button" class="ui icon red  button" onclick="askDeleteYoutube({{$youtube->id}});">
                            <i class="trash icon"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4">
                <div class="ui right floated pagination menu">
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="item">1</a>
                    <a class="item">2</a>
                    <a class="item">3</a>
                    <a class="item">4</a>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

    <script>
        function askDeleteYoutube(id) {
            if (confirm('คุณต้องการลบวิดิโอนี้ ใช่หรือไม่')) {
                var frmid = "#frmDeleteYoutube_" + id;
                $(frmid).submit();
            }
        }
    </script>
</div>

<div class="ui bottom attached tab" data-tab="fifth">
    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="5">
                <form class="ui project user form" method="post"
                      action="/backend/admin/project/{{$project->id}}/doAddUser">
                    {{csrf_field()}}
                    <div class="fields">
                        <div class="thirteen wide field">
                            <label>ค้นหานักวิจัย</label>
                            <div id="searchAddUser" class="ui fluid search selection dropdown">
                                <input type="hidden" name="user[id]">
                                <i class="dropdown icon"></i>
                                <div class="default text">ค้นหานักวิจัย</div>
                            </div>

                        </div>

                        <div class="three wide field">
                            <label>&nbsp;</label>
                            <button id="userAddBtn" type="submit" class="ui labeled icon button">
                                <i class="plus icon"></i>
                                เพิ่ม
                            </button>
                        </div>
                    </div>

                </form>
            </th>
        </tr>
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อ-นามสกุล</th>
            <th>คณะ</th>
            <th>E-Mail</th>
            <th>การจัดการ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($project->users as $user)
            <tr>
                <td class="center aligned collapsing">{{$user->id}}</td>
                <td class="">
                    {{$user->title}}{{$user->firstname}} {{$user->lastname}}
                </td>
                <td class="collapsing">
                    {{$user->faculty->name_th}}
                </td>
                <td class="collapsing">
                    {{$user->email}}
                </td>
                <td class="center aligned collapsing">
                    <form class="inline" id="frmDeleteUser_{{$user->id}}" method="post"
                          action="/backend/admin/project/{{$project->id}}/user/{{$user->id}}/delete">
                        {{csrf_field()}}

                        <button type="button" class="ui icon red  button" onclick="askDeleteUser({{$user->id}});">
                            <i class="trash icon"></i>
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="5">
                <div class="ui right floated pagination menu">
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="item">1</a>
                    <a class="item">2</a>
                    <a class="item">3</a>
                    <a class="item">4</a>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>

    <script>
        $(document).ready(function () {
            $("#searchAddUser").dropdown({
                apiSettings: {
                    url: '/api/researcher/dropdown/{query}',
                    onResponse: function (response) {
                        //console.log(response);
                    }

                },
                fields: {
                    remoteValues: 'results', // grouping for api results
                    //values       : 'values', // grouping for all dropdown values
                    name: 'fullname',   // displayed dropdown text
                    value: 'id'   // actual dropdown value
                },
                onChange: function (value, text, $choice) {
                    console.log(value);
                }

            })
        })

        function askDeleteUser(id) {
            if (confirm('คุณต้องการนำนักวิจัยนี้ออกจากโครงการนี้ ใช่หรือไม่')) {
                var frmid = "#frmDeleteUser_" + id;
                $(frmid).submit();
            }
        }

    </script>
</div>

<div class="ui bottom attached tab" data-tab="sixth">

    <form class="ui form">
        <div class="field">
            <div id="color-palette"></div>
            <div>
                <button type="button" id="delete-button">Delete Selected Shape</button>
            </div>
        </div>
        <div class="field">
            <div id="gmap" style="with:300px;height:600px;"></div>
        </div>
    </form>

</div>

<script>

    var drawingManager;
    var selectedShape;
    var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
    var selectedColor;
    var colorButtons = {};

    function clearSelection() {
        if (selectedShape) {
            selectedShape.setEditable(false);
            selectedShape = null;
        }
    }

    function setSelection(shape) {
        clearSelection();
        selectedShape = shape;
        shape.setEditable(true);
        selectColor(shape.get('fillColor') || shape.get('strokeColor'));
    }

    function deleteSelectedShape() {
        if (selectedShape) {
            selectedShape.setMap(null);
        }
    }

    function selectColor(color) {
        selectedColor = color;
        for (var i = 0; i < colors.length; ++i) {
            var currColor = colors[i];
            colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
        }

        // Retrieves the current options from the drawing manager and replaces the
        // stroke or fill color as appropriate.
        var polylineOptions = drawingManager.get('polylineOptions');
        polylineOptions.strokeColor = color;
        drawingManager.set('polylineOptions', polylineOptions);

        var rectangleOptions = drawingManager.get('rectangleOptions');
        rectangleOptions.fillColor = color;
        drawingManager.set('rectangleOptions', rectangleOptions);

        var circleOptions = drawingManager.get('circleOptions');
        circleOptions.fillColor = color;
        drawingManager.set('circleOptions', circleOptions);

        var polygonOptions = drawingManager.get('polygonOptions');
        polygonOptions.fillColor = color;
        drawingManager.set('polygonOptions', polygonOptions);
    }

    function setSelectedShapeColor(color) {
        if (selectedShape) {
            if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
                selectedShape.set('strokeColor', color);
            } else {
                selectedShape.set('fillColor', color);
            }
        }
    }

    function makeColorButton(color) {
        var button = document.createElement('span');
        button.className = 'color-button';
        button.style.backgroundColor = color;
        google.maps.event.addDomListener(button, 'click', function () {
            selectColor(color);
            setSelectedShapeColor(color);
        });

        return button;
    }

    function buildColorPalette() {
        var colorPalette = document.getElementById('color-palette');
        for (var i = 0; i < colors.length; ++i) {
            var currColor = colors[i];
            var colorButton = makeColorButton(currColor);
            colorPalette.appendChild(colorButton);
            colorButtons[currColor] = colorButton;
        }
        selectColor(colors[0]);
    }

    function initialize() {
        var map = new google.maps.Map(document.getElementById('gmap'), {
            zoom: 10,
            center: new google.maps.LatLng(22.344, 114.048),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true
        });

        var polyOptions = {
            strokeWeight: 0,
            fillOpacity: 0.45,
            editable: true
        };
        // Creates a drawing manager attached to the map that allows the user to draw
        // markers, lines, and shapes.
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            markerOptions: {
                draggable: true
            },
            polylineOptions: {
                editable: true
            },
            rectangleOptions: polyOptions,
            circleOptions: polyOptions,
            polygonOptions: polyOptions,
            map: map
        });

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
            if (e.type != google.maps.drawing.OverlayType.MARKER) {
                // Switch back to non-drawing mode after drawing a shape.
                drawingManager.setDrawingMode(null);

                // Add an event listener that selects the newly-drawn shape when the user
                // mouses down on it.
                var newShape = e.overlay;
                newShape.type = e.type;
                google.maps.event.addListener(newShape, 'click', function () {
                    setSelection(newShape);
                });
                setSelection(newShape);
            }
        });

        // Clear the current selection when the drawing mode is changed, or when the
        // map is clicked.
        google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
        google.maps.event.addListener(map, 'click', clearSelection);
        google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

        buildColorPalette();
    }


    $('.menu .item').tab({
        onVisible: function (tab) {
            if (tab == "sixth") {

                initialize();
            }
        }
    });

    $('.menu .item').tab('change tab', "{{$step}}")


    $('form .dropdown')
            .dropdown({})
    ;


</script>