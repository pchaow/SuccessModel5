@extends('frontends.layout')

@section('content')

    <?php
    $projects = \App\Models\Project::all();
    $colProject1 = $projects->every(3, 0);
    $colProject2 = $projects->every(3, 1);
    $colProject3 = $projects->every(3, 2);

    $columnsProject = [$colProject1, $colProject2, $colProject3];
    ?>

    <div class="ui three columns grid">
        @foreach($columnsProject as $col)
            <div class="column">
                @foreach($col as $project)
                    <div class="ui fluid card">
                        <div class="image">
                            @if($project->cover_file == "")
                                <img src="/images/uplogo_big.png">
                            @else
                                <img src="/project/{{$project->id}}/cover/{{$project->cover_file}}">
                            @endif
                        </div>
                        <div class="content">
                            <a href="/project/{{$project->id}}" class="header">{{$project->name_th}}</a>
                            <div class="meta">
                                <span class="faculty">{{$project->faculty->name_th}}</span>
                            </div>
                            <div class="description">
                                {{\Illuminate\Support\Str::limit($project->description_th, 255)}}
                            </div>
                        </div>
                        <div class="extra content">
                            <a>
                                <i class="user icon"></i>
                                22 Friends
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

@endsection
