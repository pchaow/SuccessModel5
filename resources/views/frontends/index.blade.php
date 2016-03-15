@extends('frontends.layout')

@section('content')


    @include('frontends.ui.map')

    <h3>โครงการวิจัย</h3>
    @include('frontends.list_projects')


    <h3>ข่าวประชาสัมพันธ์</h3>
    @include('frontends.list_posts')

    <script type="text/javascript">
        $(document).ready(function () {
            $('.lazy').Lazy({
                combined: true,
                delay: 500
            });

        })
    </script>
@endsection
