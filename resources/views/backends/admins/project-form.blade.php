<div class="ui pointing secondary menu">
    <a class="item active" data-tab="first">ข้อมูลเบื้องต้น</a>
    @if($type=="EDIT")
        <a class="item" data-tab="second">ภาพปก</a>
        <a class="item" data-tab="third">Third</a>
    @endif
</div>

<div class="ui bottom attached tab active" data-tab="first">
    <form class="ui form" action="{{$action}}" method="post">
        {{csrf_field()}}
        <div class="field">
            <label>กอง/คณะ/วิทยาลัย</label>
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
            <label>รายละเอียดโครงการ ภาษาไทย</label>
            <textarea name="project[description_th]" rows="10">{{$project->description_th}}</textarea>
        </div>

        <div class="field">
            <label>รายละเอียดโครงการ ภาษาอังกฤษ(ถ้ามี)</label>
            <textarea name="project[description_en]" rows="10">{{$project->description_en}}</textarea>
        </div>


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
            <img id="previewImage" src="" alt="Image preview...">
        </div>

        <button class="ui button" tabindex="0">ยืนยัน</button>
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
            }

            $("#coverInput").on("change", previewFile);

        </script>
    </form>
</div>

<div class="ui bottom attached tab " data-tab="third">
    Third
</div>
