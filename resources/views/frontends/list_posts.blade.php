<?php

$colPost1 = $posts->every(3, 0);
$colPost2 = $posts->every(3, 1);
$colPost3 = $posts->every(3, 2);

$colPosts = [$colPost1, $colPost2, $colPost3];
?>

<div class="ui three columns grid">
    @foreach($colPosts as $col)
        <div class="column">
            @foreach($col as $post)
                <div class="ui fluid card">
                    <div class="image">
                        @if($project->cover_file == "")
                            <img src="/images/uplogo_big.png">
                        @else
                            <img class="lazy"
                                 data-src="/post/{{$post->id}}/cover/{{$post->cover_file}}?w=357&fit=max">
                        @endif
                    </div>
                    <div class="content">
                        <a href="/post/{{$post->id}}" class="header">{{$post->title}}</a>
                        <div class="description" style="text-align: justify;">
                            {{\Illuminate\Support\Str::limit(strip_tags($post->content),255)}}
                        </div>
                    </div>
                    <div class="extra content">
                        <a href="/post/{{$post->id}}">อ่านต่อ</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>