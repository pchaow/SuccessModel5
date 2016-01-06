<form class="ui form" action="{{$action}}" method="post">
    <div class="field">
        <label>ชื่อคณะภาษาไทย</label>
        <input type="text" name="faculty[name_th]" placeholder="ชื่อคณะภาษาไทย" value="{{$faculty->name_th}}">
    </div>
    <div class="field">
        <label>ชื่อคณะอังกฤษ</label>
        <input type="text" name="faculty[name_en]" placeholder="ชื่อคณะภาษาอังกฤษ" value="{{$faculty->name_en}}">
    </div>

    <button class="ui button" type="submit">ตกลง</button>
    <a class="ui red button" href="{{$cancel}}">ยกเลิก</a>
</form>