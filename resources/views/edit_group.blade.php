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
                    <h4>グループの編集</h4>
                    <br/>
                    {{-- <form action="" method="POST" id="creategroup"> --}}
                        <form action="{{url('edit_group_action/'.Crypt::encrypt($client[0]->id))}}" method="POST" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">グループ名 </label>
                            </div>
                            <div class="col-md-8">
                                @foreach($client as $c)
                                    <input type="text" class="form-control" name="groupname" id="groupname" style="width:75%" value="{{$c->group_name}}">
                                    <p class="errormsg" id="nameerrormsg">Please enter name above</p>
                                @endforeach

                            </div>

                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">ユーザー追加</label>
                            </div>
                            <div class="col-md-8">

                                <div class="multiselect">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                      <select>
                                        <option>Select User</option>
                                      </select>
                                      <div class="overSelect"></div>
                                    </div>
                                    <div id="checkboxes">
                                        {{-- @foreach ($user as $u)
                                            @foreach($name as $n)
                                                <label>
                                                    <input type="checkbox" id="one" name="username[]" value="{{ $u->id }}" @if ($u->id == $n->id) checked @endif/>  {{ $u->name }}
                                                </label>
                                            @endforeach
                                        @endforeach --}}
                                        @foreach ($user as $u)

                                                <label>
                                                    <input type="checkbox" id="one" name="username[]" value="{{ $u->id }}" @if (is_array($name) && in_array($u->id, $name)) checked @endif/>  {{ $u->name }}
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
                                        <select class="form-control" id="test" name="starttime_hour" style="width:100%;padding-left: 10px;padding-top: 5px;">
                                            {{-- <option value="">Hour</option> --}}
                                            @foreach($client as $c)
                                                <option value="{{ $c->start_autobet_hour }}">{{ $c->start_autobet_hour }}</option>
                                            @endforeach

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
                                        <select class="form-control" id="test" name="starttime_min" style="width:100%;padding-left: 10px;padding-top: 5px;">
                                            {{-- <option value="">--- Select User ---</option> --}}
                                            @foreach($client as $c)
                                                <option value="{{ $c->start_autobet_min }}">{{ $c->start_autobet_min }}</option>
                                            @endforeach
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
                                    {{-- <input type="number" min="00" max="24" name="stoptime_hour" style="width: 75%; margin-left: -25%" placeholder="Hour"> --}}
                                        <select class="form-control" id="test" name="stoptime_hour" style="width:100%;padding-left: 10px;padding-top: 5px;">
                                            {{-- <option value="">Hour</option> --}}
                                            @foreach($client as $c)
                                                <option value="{{ $c->stop_autobet_hour }}">{{ $c->stop_autobet_hour }}</option>
                                            @endforeach
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
                                        <select class="form-control" id="test" name="stoptime_min" style="width:100%;padding-left: 10px;padding-top: 5px;">
                                            {{-- <option value="">--- Select User ---</option> --}}
                                            @foreach($client as $c)
                                                <option value="{{ $c->stop_autobet_min }}">{{ $c->stop_autobet_min }}</option>
                                            @endforeach
                                            @foreach ($min as $m)
                                                <option value="{{ $m }}">{{ $m }}</option>
                                            @endforeach
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
                                <input type="checkbox" id="streetaddr" name="days[]" value="6" @if (is_array($daysarray) && in_array('6', $daysarray)) checked @endif>
                                <label for="vehicle1"> 土</label>

                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="7" @if (is_array($daysarray) && in_array('7', $daysarray)) checked @endif>
                                <label for="vehicle1"> 日</label>

                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="1" @if (is_array($daysarray) && in_array('1', $daysarray)) checked @endif>
                                <label for="vehicle1"> 月</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="2" @if (is_array($daysarray) && in_array('2', $daysarray)) checked @endif>
                                <label for="vehicle1"> 火</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="3" @if (is_array($daysarray) && in_array('3', $daysarray)) checked @endif>
                                <label for="vehicle1"> 水</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="4" @if (is_array($daysarray) && in_array('4', $daysarray)) checked @endif>
                                <label for="vehicle1"> 木</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="5" @if (is_array($daysarray) && in_array('5', $daysarray)) checked @endif>
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
                                        @foreach($client as $c)
                                            <input type="number" min="0" class="form-control" style="background: white;text-align:center;"name="winningamount" value="{{$c->winning_double}}">
                                        @endforeach

                                    </div>
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 倍 </p>
                                    </div>

                                </div>
                                <div class="row mt-2" style="border: 1px solid black;width:75%;background: #C0C0C0;">
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 負金額 </p>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        @foreach($client as $c)
                                            <input type="number" min="0" class="form-control" style="background: white;text-align:center;"name="negativeamount" value="{{$c->winning_double}}">
                                        @endforeach
                                    </div>
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 倍 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">Table count</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="tablecount" id="tablecount" style="width:75%" value="{{($client[0]->terminate_table_count > 0)?$client[0]->terminate_table_count: ''}}">
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
        // window.alert("You clicked Submit!");
        var groupname = document.getElementById("groupname");
        // var Check = document.getElementById("vehicle1");
        // var quantityCheck = document.getElementById("quantity");
        var is_valid = false;
        /* If statements to check if text box is empty */
        document.getElementById("nameerrormsg").style.display = "none";
        // document.getElementById("addrerrormsg").style.display = "none";
        // document.getElementById("qtyerrormsg").style.display = "none";
        is_valid = true;

        if (groupname.value == "") {
            document.getElementById("nameerrormsg").style.display = "inline";
            is_valid = false;
        }

    return is_valid;
    }
</script>

<script>
    function validateForm() {
    var x1 = document.forms["creategroup"]["groupname"].value;
    //   var x2 = document.forms["creategroup"]["username[]"].value;
    //   var x3 = document.forms["creategroup"]["starttime"].value;
    //   var x4 = document.forms["creategroup"]["stoptime"].value;
    var x5 = document.forms["creategroup"]["days[]"].value;
    //   var x6 = document.forms["creategroup"]["winningamount"].value;
    //   var x7 = document.forms["creategroup"]["negativeamount"].value;

    if (x1 == "" || x5 == "") {
        alert("Missing content");
        return false;
    }
    }
</script>


<style>

.errormsg {
  color: red;
  /* background-color: yellow; */
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
  /* font-weight: bold; */
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
