@extends('app')
@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <h2 class="color">Hello This is Swoole!</h2>
            <h5>
                <ul>
                    @foreach($users as $user)
                        <li>{{$user->phone . ' : ' .$user->name}} </li>
                    @endforeach
                </ul>
            </h5>
            <div>
                {!! paginator($users) !!}
            </div>
        </div>
    </div>
@endsection

