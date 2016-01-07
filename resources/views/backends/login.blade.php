@extends('backends.master')

@section('layout')
    <div class="ui centered grid">
        <div class="six wide column">
            <div class="ui top attached inverted  segment" style="background-color: #4c1d6e;">
                <h4>เข้าใช้งานระบบ / Sign in</h4>
            </div>

            @if($errors->any())

                <div class="ui attached segment">
                    <div class="ui negative message">
                        <div class="header">We had some issues</div>
                        <ul class="list">
                            @foreach($errors->all() as $e)
                                <li><?php print_r($e)?></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="ui attached segment">
                <form class="ui form" action="/backend/doLogin" method="post">
                    {{csrf_field()}}
                    <div class="ui field">
                        <label>Username or E-Mail</label>

                        <div class="ui left icon input">
                            <i class="mail icon"></i>
                            <input name="user[email]" type="text" placeholder="Username & E-Mail">
                        </div>

                    </div>
                    <div class="ui field">
                        <label>Password</label>

                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input name="user[password]" type="password" placeholder="Password">
                        </div>

                    </div>
                    <div class="ui grid">
                        <div class="row two column">
                            <div class="column">
                                <button type="submit" class="fluid ui primary button">User Login</button>
                            </div>
                            <div class="column">
                                <a href="#" class="fluid ui positive button">Register</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("button[type=submit]").click(function (ev) {

            })
        })
    </script>

@endsection
