<!doctype html>
<html lang="en">
@include('layout.head')
<body>
<div id="loading"></div>
<div class="wrapper">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-12 text-center">
                <div class="iq-error">
                    <img src="{{asset('/images/error/01.png')}}" class="img-fluid iq-error-img" alt="">
                    <h3 class="mb-0 mt-4">Oops! This Page is Not Found.</h3>
                    <p>The requested page dose not exist.</p>
                    <a class="btn btn-primary mt-3" href="/"><i class="ri-home-4-line"></i>Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layout.js')
</body>
</html>
