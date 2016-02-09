<!DOCTYPE HTML>
<html>
<head>
    <meta name="csrf_token" value="<?php echo csrf_token(); ?>">
    <link rel="stylesheet" href="/bower/semantic/dist/semantic.min.css"/>
    <link rel="stylesheet" href="/bower/semantic/dist/components/dropdown.min.css"/>
    <script src="/bower/jquery/dist/jquery.min.js"></script>
    <script src="/bower/semantic/dist/semantic.min.js" type="text/javascript"></script>
    <script src="/bower/semantic/dist/components/dropdown.min.js" type="text/javascript"></script>

    @yield('javascript')

</head>

<body>

<div class="ui grid">
    <div class="row" style="background-color: #4c1d6e">
        <div class="ui stackable  middle aligned grid container">
            <div class="three wide column">
                <h2 class="ui header inverted" style="padding: 20px;">
                    <div class="ui small image">
                        <a href="/">
                            <img src="/images/logo-text.png">
                        </a>
                    </div>
                </h2>
            </div>
            <div class="ten wide column">
                <form action="/project" method="get">
                <div class="ui fluid icon input">
                    <input type="text" name="keyword" placeholder="ค้นหา...">
                    <i class="search icon"></i>
                </div>
                </form>
            </div>
            <div class="three wide column">
                <a href="/backend/login" style="text-decoration: none; color:white;">เข้าสู่ระบบ</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="ui container">
            @yield('layout')

        </div>
    </div>
</div>
<p></p>
<div class="ui inverted vertical footer segment" style="background-color: #4c1d6e">
    <div class="ui center aligned container">
        <div class="ui horizontal inverted small divided link list">
            © 2015 University of Phayao. ALL Rights Reserved
        </div>
    </div>
</div>

</body>
