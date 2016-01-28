@if($role=="ADMIN")
    <table class="ui celled table">
        <thead>
        <tr>
            <th colspan="4">
                <a href="/backend/post/addForm" class="ui labeled icon button">
                    <i class="plus icon"></i>
                    เพิ่มข่าวประกาศ
                </a>
                <div class="ui right floated menu">
                    <div class="item">
                        <div class="ui transparent icon input">
                            <input type="text" placeholder="Search...">
                            <i class="search link icon"></i>
                        </div>
                    </div>
                </div>

            </th>
        </tr>
        <tr>
            <th classs="center aligned collapsing">ลำดับ</th>
            <th>ชื่อ</th>
            <th class="center aligned collapsing">แก้ไข</th>
            <th class="center aligned collapsing">ลบ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td class="center aligned collapsing">{{$post->id}}</td>
                <td>
                    <b>{{$post->title}}</b>
                </td>
                <td class="center aligned collapsing">
                    <a href="/backend/post/{{$post->id}}/edit" class="ui icon blue button">
                        <i class="edit icon"></i>
                    </a>
                </td>
                <td class="center aligned collapsing">
                    <form class="inline" id="frmdelete_{{$post->id}}" method="post"
                          action="/backend/post/{{$post->id}}/delete">
                        {{csrf_field()}}
                        <button type="button" class="ui icon red  button deleteProjectBtn">
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
@endif

<script type="text/javascript">

    $(".deleteProjectBtn").on('click', function () {
        if (confirm('คุณต้องการลบข่าว ใช่หรือไม่')) {
            $(this).parent().submit();
        }
    })

</script>
