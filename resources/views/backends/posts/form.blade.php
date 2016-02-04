<div class="ui pointing secondary menu">
    <a class="item active" data-tab="first">ข้อมูลเบื้องต้น</a>
    @if($type=="EDIT")
        <a class="item" data-tab="second">ภาพปก</a>
        <a class="item" data-tab="third">รูปภาพ</a>
    @endif
</div>

<div class="ui bottom attached tab active" data-tab="first">
    <form class="ui form" action="{{$action}}" method="post">
        {{csrf_field()}}

        <div class="field">
            <label>หัวเรื่อง</label>
            <input type="text" name="postForm[title]" placeholder="หัวเรื่อง" value="{{$post->title}}">
        </div>

        <div class="field">
            <label>เนื้อเรื่อง</label>
            <textarea id="post_content" name="postForm[content]"
                      rows="10">{{$post->title}}</textarea>
        </div>


        @if($role =="ADMIN")
            <div class="field">
                <label>สถานะข่าวประกาศ</label>
                <div class="ui selection dropdown" tabindex="0">
                    <input type="hidden" name="postForm[status][id]" value="{{$post->status_id}}">
                    @if($post->status_id)
                        <div class="text">{{$post->status->key}}</div>
                    @else
                        <div class="default text">กรุณาเลือก</div>
                    @endif
                    <i class="dropdown icon"></i>
                    <div class="menu transition hidden" tabindex="-1">
                        <?php
                        $statuses = \App\Models\Posts\PostStatus::all();
                        ?>
                        @foreach($statuses as $status)
                            <div class="item {{ $post->status_id == $status->id ? "active" : ""  }}"
                                 data-value="{{$status->id}}">
                                {{$status->key}}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @else
            <?php
            $draft = \App\Models\Posts\PostStatus::where('key', '=', 'draft')->first();
            ?>
            <input type="hidden" name="post[status][id]" value="{{$post->status_id or $draft->id}}"/>
        @endif

        @if($type == "ADD")
            <button class="ui button" tabindex="0">บันทึกข่าวประกาศใหม่</button>
        @else
            <button class="ui button" tabindex="0">บันทึกข่าวประกาศ</button>
        @endif

        <a href="{{$cancel}}" class="ui red button" tabindex="0">ยกเลิก</a>

    </form>

    <script>
        $(document).ready(function () {

            var config = {};

            config.toolbar = [
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']},
                {name: 'styles', items: ['Format']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']},
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ];

            CKEDITOR.replace('post_content', config);

        });
    </script>

</div>

<div class="ui bottom attached tab " data-tab="second">
    <form class="ui form" method="post" action="/backend/post/{{$post->id}}/doSaveCover"
          enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="field">
            <label>ภาพปก</label>
            <button id="coverUploadBtn" type="button" class="ui blue button" tabindex="0">เลือกไฟล์</button>
            <span id="filename"></span>

            <div style="width:0px;height: 0px;overflow: hidden;">
                <input id="coverInput" type="file" name="post[cover_upload]">
            </div>
        </div>

        <div class="field">
            @if($post->cover_file)
                <img id="previewImage" height="200"
                     src="/backend/post/{{$post->id}}/getCover/{{$post->cover_file}}?h=200"
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
                      action="/backend/post/{{$post->id}}/doUploadPhoto">
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
        @foreach($post->photos as $photo)
            <tr>
                <td class="center aligned collapsing">{{$photo->id}}</td>
                <td class="collapsing">
                    <img id="previewImage" height="200"
                         src="/backend/post/{{$post->id}}/photos/{{$photo->filename}}?h=200"
                         alt="Image preview...">
                </td>
                <td class="">

                    <div id="description_{{$photo->id}}">
                        {{$photo->description or "" }}
                    </div>

                    <form id="descriptionFrm_{{$photo->id}}" class="ui form" style="display:none;" method="post"
                          action="/backend/post/{{$post->id}}/photo/{{$photo->id}}/doEditPhoto">
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
                          action="/backend/post/{{$post->id}}/photo/{{$photo->id}}/delete">
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

<script>


    $(document).ready(function () {
        $('.menu .item').tab('change tab', "{{$step or "first"}}")


        $('form .dropdown')
                .dropdown({})
        ;

        console.log('test');
    })


</script>