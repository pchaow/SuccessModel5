@extends('backends.layout')

@section('content')

    <h2>ข่าวประกาศ</h2>

    @include('backends.posts.table', [
            'role' => 'ADMIN'
        ])
@endsection
