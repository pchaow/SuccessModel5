@extends('backends.layout')

@section('content')

    <h2>รายการโครงการ</h2>

    @include('backends.project.table', [
            'role' => 'RESEARCHER'
        ])
@endsection
