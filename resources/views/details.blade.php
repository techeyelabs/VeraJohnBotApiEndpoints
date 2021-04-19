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
                            <h4><a href="{{ route('filedownload') }}">http://{{$_SERVER['HTTP_HOST']}}/VeraJohnBotApiEndpoints/public/installerdownload?id=bot-{{$c->token}}</a></h4>
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
                            {{-- <a href="javascript:;" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;" onclick="myFunction()">BET 履歴</a> --}}
                        </div>
                    </div>

                    {{-- <div class="table-responsive col-md-8 pb-3" id="bethistory" style="margin: auto; display: none;">
                        <h3 style="text-align: center;">Bet History</h3>
                        <table class="table" id="table">
                            <thead class=" text-primary">
                                <tr>
                                    <th> 日付  </th>
                                    <th> 金額  </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $d  )
                                    <tr>
                                        <td>{{ $d->created_at }} </td>
                                        <td>{{ $d->aftermath }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        </div>
    </div>
 {{-- <script>
        function myFunction() {
            var x = document.getElementById("bethistory");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
        }
    </script> --}}
   {{--   <script>
        function myFunction1() {
            var x = document.getElementById("deposits");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <script>
        function myFunction2() {
            var x = document.getElementById("withdrawls");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script> --}}
@endsection
