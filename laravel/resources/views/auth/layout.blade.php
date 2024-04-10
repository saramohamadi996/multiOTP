<!doctype html>
<html lang="en">
@include('layout.head')
<body>
<div id="loading"></div>
<section class="sign-in-page">
    <div class="container p-0">
        <div class="row no-gutters">
            <div class="col-sm-12 align-self-center">
                @yield('content')
            </div>
        </div>
    </div>
</section>
@include('layout.js')
</body>
</html>
