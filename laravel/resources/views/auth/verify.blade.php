@extends('auth.layout')
@section('content')
    <div class="sign-in-from bg-white">
        <p>Enter your otp code.</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <form class="mt-4" method="POST" action="{{ route('verify') }}">
            @csrf
            <div class="form-group">
                <input type="hidden" name="identity" value="{{ old('identity', session('identity')) }}">
                <label for="otp_code">Verify</label>
                <input type="text" class="form-control mb-0" name="otp_code"
                       placeholder="Enter your Code" required>
            </div>
            <div class="d-inline-block w-100">
                <button type="submit" class="btn btn-primary float-right">Verify</button>
            </div>
        </form>
    </div>
@endsection
