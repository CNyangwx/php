@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="/threads" method="post" role="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="title">标题:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Input...">
                    </div>
                    <div class="form-group">
                        <label for="body">内容:</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="请填写内容..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">提交</button>
                </form>
            </div>
        </div>
    </div>
@endsection
