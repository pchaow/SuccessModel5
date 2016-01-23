@extends('frontends.layout')

@section('content')

    <div class="ui grid">
        <div class="sixteen wide column">
            <div class="ui vertical segment">
                <div class="ui grid">
                    <div class="eight wide column">
                        <img class="ui fluid image"
                             src="/project/{{$project->id}}/cover/{{$project->cover_file}}?h=300&crop=fit">
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
            <div class="ui vertical segment">
                {!! $project->description_th !!}
                <div class="ui divider"></div>
                {!! $project->description_en !!}

            </div>
            <div class="ui vertical segment">
                
            </div>


        </div>

    </div>



@endsection
