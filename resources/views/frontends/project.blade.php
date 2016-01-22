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
                            <div class="sub header"> {{$project->location}} {{$project->district->DISTRICT_NAME}} {{$project->amphur->AMPHUR_NAME}} {{$project->province->PROVINCE_NAME}}</div>

                        </h3>
                    </div>
                </div>
            </div>
            <div class="ui vertical segment">
                <p>
                    {!! $project->description_th !!}
                </p>
                <p>
                    {!! $project->description_en !!}
                </p>
            </div>
            <div class="ui vertical segment">
                <div class="ui four column grid">
                    @foreach($project->photos as $photo)
                        <div class="column">
                            <div class="ui segment">
                                <img class="ui image"
                                     src="/project/{{$project->id}}/photos/{{$photo->filename}}?w=300&h=300&fit=crop">
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>


        </div>

    </div>



@endsection
