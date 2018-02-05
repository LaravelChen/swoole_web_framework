@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
                <form method="POST" action="{{url('get_avatar')}}" accept-charset="UTF-8"  enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="file" name="image">
                    <button type="submit" class="btn btn-success form-control">上传</button>
                </form>
            </div>
        </div>
    </div>
@endsection