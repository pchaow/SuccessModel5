@extends('frontends.layout')

@section('content')

    @include('frontends.list_projects')



    <script type="text/javascript">
        $(document).ready(function () {
            $('.lazy').Lazy({
                combined : true,
                delay : 500
            });

        })
    </script>
@endsection
