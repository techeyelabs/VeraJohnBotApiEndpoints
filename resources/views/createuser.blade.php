@extends('layouts.app')
@section('pagetitle')
    <a class="navbar-brand" href="javascript:;"></a>
@endsection
@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title" style="text-align: center;">新規ユーザー登録</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('create-user-action')}}" method="POST" id="logForm">
                                {{ csrf_field() }}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">お名前 </label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">メールアドレス</label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">電話番号</label>
                                            <input type="text" class="form-control" name="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">住所 </label>
                                            <input type="text" class="form-control" name="address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">その他 </label>
                                            <input type="text" class="form-control" name="other">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">パスワード</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">登録する</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div>
@endsection
