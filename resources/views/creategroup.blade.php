@extends('layouts.app')
@section('pagetitle')
<a class="navbar-brand" href="javascript:;"></a>
@endsection
{{-- https://investmentnovel.com/laravel-dependent-dropdown-tutorial-with-example/ --}}


@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card card-profile">
                <div class="card-body">
                    <h4>自動 BET 設定 ( グループ )</h4>
                    <br>
                    {{-- <form action="" method="POST" id="creategroup"> --}}
                        <form action="{{route('create-group-action')}}" onsubmit="return checkForm();" method="POST" id="creategroup">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">グループ名</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="groupname" id="groupname" style="width:75%">
                                <p class="" id="nameerrormsg" style="float: left; color: red; font-size: 11px; display: none">上に名前を入力してください</p>
                            </div>

                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">ユーザー追加</label>
                            </div>
                            <div class="col-md-8">

                                <div class="multiselect">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                      <select>
                                        <option>ユーザー選択 / 追加</option>
                                      </select>
                                      <div class="overSelect"></div>
                                    </div>
                                    <div id="checkboxes">
                                        @foreach ($client as $cl)
                                        <label>
                                            <input type="checkbox" id="one" name="username[]" value="{{ $cl->id }}"/>  {{ $cl->name }}
                                        </label>
                                        @endforeach
                                    </div>
                                  </div>

                            </div>

                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">自動 BET 開始 </label>
                            </div>
                            <div class="row col-md-8">
                                <div class="row col-md-6">
                                    <div class="col-md-4">
                                    {{-- <input type="number" min="00" max="24" name="starttime_hour" style="width: 75%; margin-left: -25%" placeholder="Hour"> --}}
                                        <select class="form-control" id="starttime_hour" name="starttime_hour" style="width:100%;padding-left: 10px;padding-top: 5px;" onchange="getend('starttime_hour')">
                                            @foreach ($hour as $h)
                                                <option value="{{ $h }}">{{ $h }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">時</p>
                                    </div>
                                </div>
                                <div class="row col-md-6">
                                    {{-- <input type="number" min="00" max="59" name="starttime_min" style="width: 75%; margin-left: -25%" placeholder="Min"> --}}
                                    <div class="col-md-4">
                                        <select class="form-control" id="starttime_min" name="starttime_min" style="width:100%;padding-left: 10px;padding-top: 5px;" onchange="getendmin('starttime_min')">
                                            @foreach ($min as $m)
                                                <option value="{{ $m }}">{{ $m }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">分</p>
                                    </div>
                                </div>
                                {{-- <input type="time" id="appt" min="00:00" max="24:00" name="starttime" style="width: 75%; margin-left: -25%"> --}}
                                {{-- <input type="text" class="form-control" name="name"> --}}
                            </div>

                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">自動 BET 終了 </label>
                            </div>
                            <div class="row col-md-8">

                                <div class="row col-md-6">
                                    <div class="col-md-4">
                                        <select class="form-control" id="stoptime_hour" name="stoptime_hour" style="width:100%;padding-left: 10px;padding-top: 5px;" disabled>
                                            {{--@foreach ($hour as $h)
                                                <option value="{{ $h }}">{{ $h }}</option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">時</p>
                                    </div>
                                </div>
                                <div class="row col-md-6">
                                    <div class="col-md-4">
                                        <select class="form-control" id="stoptime_min" name="stoptime_min" style="width:100%;padding-left: 10px;padding-top: 5px;" disabled>
                                            {{--@foreach ($min as $m)
                                                <option value="{{ $m }}">{{ $m }}</option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">分</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">曜日設定 </label>
                            </div>
                            <div class="col-md-8" style="margin-left: -9%;">
                                <input type="checkbox" id="streetaddr" name="days[]" value="6">
                                <label for="vehicle1"> 土</label>

                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="7">
                                <label for="vehicle1"> 日</label>

                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="1">
                                <label for="vehicle1"> 月</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="2">
                                <label for="vehicle1"> 火</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="3">
                                <label for="vehicle1"> 水</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="4">
                                <label for="vehicle1"> 木</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="5">
                                <label for="vehicle1"> 金</label>

                            </div>
                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%; display: none">
                                <label class="bmd-label-floating" style="margin-top: 42px;">自動終了金額指定 </label>
                            </div>
                            <div class="col-md-8 pl-4" style="display: none">
                                <div class="row" style="border: 1px solid black;width:75%;background: #C0C0C0;">
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 勝金額 </p>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <input type="number" min="0" class="form-control" style="background: white;text-align:center;"name="winningamount">
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <p style="margin-top: 6px;"> 倍 </p>
                                    </div>

                                </div>
                                <div class="row mt-2" style="border: 1px solid black;width:75%;background: #C0C0C0;">
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 負金額 </p>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <input type="number" min="0" class="form-control" style="background: white;text-align:center;"name="negativeamount">
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <p style="margin-top: 6px;"> 倍 </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">Table count</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="tablecount" id="tablecount" style="width:75%">
                                {{--<p class="" id="nameerrormsg" style="float: left; color: red; font-size: 11px; display: none">上に名前を入力してください</p>--}}
                            </div>
                            <div class="col-md-12">
                                <div class="" style="margin: auto;">
                                    <button class="btn" style="margin: 0; padding: 0; width: 150px; height: 35px">保存</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

</script>

<script>
    function checkForm() {
        var groupname = document.getElementById("groupname");
        document.getElementById("nameerrormsg").style.display = "none";
        is_valid = true;
        if (groupname.value == "") {
            document.getElementById("nameerrormsg").style.display = "inline";
            is_valid = false;
        }
        return is_valid;
    }

    function getend(starthour){
        let starvalhour = $('#'+starthour).val();
        console.log(starvalhour);
        var ajaxurl = "{{route('get-end-hour')}}";
        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': starvalhour
            },
            success: function(data){
                console.log(data);
                $('#stoptime_hour').prop('disabled', false);
                $('#stoptime_hour').html(data.res);
            },
        });
    }

    function getendmin(startmin){
        let starvalmin = $('#'+startmin).val();
        console.log(starvalmin);
        var ajaxurl = "{{route('get-end-min')}}";
        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': starvalmin
            },
            success: function(data){
                console.log(data);
                $('#stoptime_min').prop('disabled', false);
                $('#stoptime_min').html(data.res);
            },
        });
    }
</script>

<style>

.errormsg {
    color: red;
    display: none;
    text-align: left;
    margin-left: -83%;
}

.multiselect {
    width: 75%;
}

.selectBox {
    position: relative;
}

.selectBox select {
    width: 100%;
    padding-left: 10px;
}

.overSelect {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
}

#checkboxes {
    display: none;
    border: 1px #dadada solid;
    text-align: left;
    padding-left: 10px;
    padding-top: 5px;
}

#checkboxes label {
    display: block;
}

#checkboxes label:hover {
    background-color: white;
}
</style>
