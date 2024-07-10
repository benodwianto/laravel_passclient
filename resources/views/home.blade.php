@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Timeline</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (Auth::user()->token)
                            @if ($tweets->count())
                                @foreach ($tweets as $tweet)
                                    <div class="media mb-3" v-for="(tweets, index) in tweets" :key="index">
                                        <img class="mr-3" src="https://via.placeholder.com/64" />

                                        <div class="media-body">
                                            <h5 class="mt-0">{{ $tweet->user->name }}</h5>
                                            {{ $tweet->body }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else
                            <p>Please <a href="{{ url('auth/passport/redirect') }}">authorize with Passport</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
