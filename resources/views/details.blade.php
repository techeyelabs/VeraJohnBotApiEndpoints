@extends('layouts.app')
@section('pagetitle')
<a class="navbar-brand" href="javascript:;"></a>
@endsection


@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-12">
          <div class="card card-profile">
            <div class="card-body">

                @foreach ($client as $c  )
                    <h4><b>{{ $c->name }}</b></h4>
                    <h4>{{ $c->email }}</h4>
                    {{-- {{ 'Hi' }} --}}
                @endforeach
                <a href="javascript:;" class="btn btn-primary btn-round" onclick="goBack()">一時停止する</a><br /><br />

                <h4 style="margin-top: 3%">クライアントアプリダウンロード用リンク</h4>
                @foreach ($client as $c  )
                    <h4>{{ $c->url }}</h4>
                @endforeach
                <a href="javascript:;" class="btn btn-primary btn-round" onclick="goBack()">メールに送信 </a>
            </div>
            <h3 style="margin-top: 3%">ベラジョン残高 2590 USD </h3><br />
            <div class="row" style="margin-top: -20px;">
                <a href="javascript:;" class="btn btn-primary btn-round col-md-3" style="margin-left: 12%;" onclick="window.location.reload();"><b>デポジット 履歴 </b></a>
                <a href="javascript:;" class="btn btn-primary btn-round col-md-3" onclick="window.location.reload();">キャッシュアウト</a>
                <a href="javascript:;" class="btn btn-primary btn-round col-md-3" onclick="window.location.reload();">BET 履歴</a>
            </div>
            <div class="row">
                <table class="table col-md-8" id="table">
                    <thead class=" text-primary">
                        <th> 日付  </th>
                        <th> 金額  </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2020/11/20 </td>
                            <td>$350.00</td>
                        </tr>
                        <tr>
                            <td>2020/11/20 </td>
                            <td>$350.00</td>
                        </tr>
                        <tr>
                            <td>2020/11/20 </td>
                            <td>$350.00</td>
                        </tr>
                        <tr>
                            <td>2020/11/20 </td>
                            <td>$350.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
         <div class="col-md-4"></div>
      </div>
    </div>
  </div>
@endsection