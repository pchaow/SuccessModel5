<form class="ui form" action="{{$action}}" method="post">
    {{csrf_field()}}
    <div class="field">
        <label>ปี พ.ศ.</label>
        <input type="number" name="year[year]" placeholder="ปี พ.ศ." value="{{$year->year}}">
    </div>

    <button class="ui button" type="submit">ตกลง</button>
    <a class="ui red button" href="{{$cancel}}">ยกเลิก</a>
</form>