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
                                
                            @endforeach
                            <a href="javascript:;" class="btn btn-primary btn-round" onclick="goBack()">一時停止する</a><br /><br />
    
                            <h4 style="margin-top: 3%">クライアントアプリダウンロード用リンク</h4>
                            @foreach ($client as $c  )
                                <h4>{{ $c->url }}</h4>
                            @endforeach
                            <a href="javascript:;" class="btn btn-primary btn-round" onclick="goBack()">メールに送信 </a>
                        </div>
                        <h3 style="margin-top: 3%">ベラジョン残高 2590 USD </h3><br />
    
                        <div class="row" style="margin-top: -20px;margin-bottom: 5%;">
                            <div class="col-md-4">
                                <a href="{{url('deposithistory/'.Crypt::encrypt($c->id))}}" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;">デポジット 履歴 </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('withdrawhistory/'.Crypt::encrypt($c->id))}}" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;">キャッシュアウト</a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('bethistory/'.Crypt::encrypt($c->id))}}" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;">BET 履歴</a>
                                {{-- <a href="javascript:;" class="btn btn-primary btn-round col-md-3" onclick="myFunction()">BET 履歴</a> --}}
                            </div>
                        </div>
                    
                        <h3 style="text-align:center;">Deposits</h3>
                        <div class="table-responsive col-md-8 pb-3" style="margin: auto;">
                            <table class="table" id="table">
                                <thead class=" text-primary">
                                    <th> 日付  </th>
                                    <th> 金額  </th>
                                </thead>
                                <tbody>
                                    @foreach ($deposit as $depo  )
                                            <tr>
                                                <td class="" style="padding: 17px !important;">{{ $depo->created_at }} </td>
                                                <td>{{ $depo->amount }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection