<!doctype html>
<html lang="en">
@include('layout.head')
<body>
<div id="loading">
    <div id="loading-center">
        <div class="loader">
            <div class="cube">
                <div class="sides">
                    <div class="top"></div>
                    <div class="right"></div>
                    <div class="bottom"></div>
                    <div class="left"></div>
                    <div class="front"></div>
                    <div class="back"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-12 text-center">
                <div class="iq-error">
                    <img src="{{ asset('images/error/03.png') }}" class="img-fluid iq-error-img" alt="">
                    <h1>500</h1>
                    <h3 class="mb-0 mt-4">Oops! This Page is Not Working.</h3>
                    <p>The requested is Internal Server Error.</p>
                    <a class="btn btn-primary mt-3" href="/"><i class="ri-home-4-line"></i>Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layout.js')
</body>
</html>
