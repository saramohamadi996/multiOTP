@extends('auth.layout')
@section('content')
    <div class="sign-in-from bg-white">
        <p>Enter your mobile number.</p>
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
        <form class="mt-4" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="identity">Mobile</label>
                <input type="text" class="form-control mb-0" id="identity" name="identity"
                       placeholder="Example: 9123456789" required>
            </div>
            <div class="d-inline-block w-100">
                <button type="submit" class="btn btn-primary float-right">Send Code</button>
            </div>
        </form>
    </div>
@endsection
