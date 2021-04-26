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
                            <a href="javascript:;" class="btn btn-primary btn-round" onclick="pause('{{ $c->id }}')">
                                {{ ($c->is_paused == 1)? "停止中":"運用中"}}
                            </a><br /><br />
                        @endforeach
                        <span id="success" class="btn btn-round" style="font-size: 20px; background-color: #4caf50; display: none">メールは正常に送信されました</span><br/>
                        <h4 style="margin-top: 3%">クライアントアプリダウンロード用リンク</h4>
                        @foreach ($client as $c  )
                            <h4><a href="{{ route('filedownload') }}">http://{{$_SERVER['HTTP_HOST']}}/installerdownload?id=bot-{{$c->token}}</a></h4>
                            <button id="mailbutton" class="btn btn-primary btn-round" onclick="sendcredstomail({{$c->id}})">メールに送信 </button>
                        @endforeach

                    </div>

                    <div class="row" style="margin-top: -20px;margin-bottom: 5%;">
                        <div class="col-md-4">
                            {{--<a href="{{url('deposithistory/'.Crypt::encrypt($c->id))}}" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;">デポジット 履歴 </a>--}}
                        </div>

                        <div class="col-md-4">
                            <a href="{{url('bethistory/'.Crypt::encrypt($c->id))}}" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;">BET 履歴</a>
                            {{-- <a href="javascript:;" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;" onclick="myFunction()">BET 履歴</a> --}}
                        </div>

                        <div class="col-md-4">
                            {{--<a href="{{url('withdrawhistory/'.Crypt::encrypt($c->id))}}" class="btn btn-primary btn-round col-md-3" style="max-width: 90%;">キャッシュアウト</a>--}}
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

<script>
    function pause(id) {
        var ajaxurl = "{{route('pause-unpause-user')}}";
        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': id
            },
            success: function(data){
                console.log(data)
                location.reload();
            },
        });
    }

    function sendcredstomail(id){
        $('#mailbutton').prop('disabled', true);
        var ajaxurl = "{{route('send-user-creds')}}";
        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                'id': id
            },
            success: function(data){
                console.log(data);
                $('#mailbutton').prop('disabled', true);
                $('#success').show();
                // location.reload();
            },
        });
    }
</script>
