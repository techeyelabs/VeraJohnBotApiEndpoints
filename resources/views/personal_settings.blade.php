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
                    <h4>自動 BET 設定 ( 個人 )</h4>
                    <br/>
                    @if (count($client) == 0)
                        <div class="mb-3"><span style="color: red; font-size: 15px; margin-bottom: 15px;">設定出来るユーザーがありません！</span></div>
                    @endif
                    <form action="{{route('personal_settings_action')}}" method="POST">
                        <input name="addeditflag" type="hidden" value="{{ ( isset($individual) ) ?  $individual['id']: 0 }}"/>
                        {{ csrf_field() }}
                        <div class="row">
                            {{-- <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">Group Name </label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="groupname" id="groupname" style="width:75%">
                                <p class="errormsg" id="nameerrormsg">Please enter name above</p>
                            </div> --}}

                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">ユーザー追加</label>
                            </div>
                            <div class="col-md-8">
                                <select name="username[]" style="width: 74%;margin-left: -27%;padding-left: 10px;" required {{ (count($client) == 0 ? 'disabled': '') }}>
                                    @foreach ($client as $cl)
                                        <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">自動 BET 開始</label>
                            </div>
                            <div class="row col-md-8">
                                <div class="row col-md-6">
                                    <div class="col-md-4">
                                    {{-- <input type="number" min="00" max="24" name="starttime_hour" style="width: 75%; margin-left: -25%" placeholder="Hour"> --}}
                                        <select class="form-control" id="starttime_hour" name="starttime_hour" style="width:100%" onchange="getend('starttime_hour')">
                                            @foreach ($hour as $h)
                                                <option value="{{ $h }}" {{ ( isset($individual) && $individual['start_autobet_hour'] == $h) ? 'selected' : '' }}>{{ $h }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">Hour</p>
                                    </div>
                                </div>
                                <div class="row col-md-6">
                                    {{-- <input type="number" min="00" max="59" name="starttime_min" style="width: 75%; margin-left: -25%" placeholder="Min"> --}}
                                    <div class="col-md-4">
                                        <select class="form-control" id="starttime_min" name="starttime_min" style="width:100%" onchange="getendmin('starttime_min')">
                                            {{-- <option value="">--- Select User ---</option> --}}
                                            @foreach ($min as $m)
                                                <option value="{{ $m }}" {{ ( isset($individual) && $individual['start_autobet_min'] == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">Min</p>
                                    </div>
                                </div>
                                {{-- <input type="time" id="appt" min="00:00" max="24:00" name="starttime" style="width: 75%; margin-left: -25%"> --}}
                                {{-- <input type="text" class="form-control" name="name"> --}}
                            </div>

                            <div class="col-md-4 pt-2" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">自動 BET 終了</label>
                            </div>
                            <div class="row col-md-8">

                                <div class="row col-md-6">
                                    <div class="col-md-4">
                                        <select class="form-control" id="stoptime_hour" name="stoptime_hour" style="width:100%" {{ (isset($individual) == 0 ? 'disabled': '') }}>
                                            @if (isset($individual))
                                                @foreach ($hour as $h)
                                                    <option value="{{ $h }}" {{ ( isset($individual) && $individual['stop_autobet_hour'] == $h) ? 'selected' : '' }}>{{ $h }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">Hour</p>
                                    </div>
                                </div>
                                <div class="row col-md-6">
                                    {{-- <input type="number" min="00" max="59" name="starttime_min" style="width: 75%; margin-left: -25%" placeholder="Min"> --}}
                                    <div class="col-md-4">
                                        <select class="form-control" id="stoptime_min" name="stoptime_min" style="width:100%" {{ (isset($individual) == 0 ? 'disabled': '') }}>
                                            @if (isset($individual))
                                                @foreach ($min as $m)
                                                    <option value="{{ $m }}" {{ ( isset($individual) && $individual['stop_autobet_min'] == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="text-align: left;margin-top: 3%;">Min</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%;">
                                <label class="bmd-label-floating">曜日設定</label>
                            </div>
                            <div class="col-md-8" style="margin-left: -9%;">
                                <input type="checkbox" id="streetaddr" name="days[]" value="6" @if (isset($daysarray) && is_array($daysarray) && in_array('6', $daysarray)) checked @endif>
                                <label for="vehicle1"> 土</label>

                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="7" @if (isset($daysarray) && is_array($daysarray) && in_array('7', $daysarray)) checked @endif>
                                <label for="vehicle1"> 日</label>

                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="1" @if (isset($daysarray) && is_array($daysarray) && in_array('1', $daysarray)) checked @endif>
                                <label for="vehicle1"> 月</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="2" @if (isset($daysarray) && is_array($daysarray) && in_array('2', $daysarray)) checked @endif>
                                <label for="vehicle1"> 火</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="3" @if (isset($daysarray) && is_array($daysarray) && in_array('3', $daysarray)) checked @endif>
                                <label for="vehicle1"> 水</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="4" @if (isset($daysarray) && is_array($daysarray) && in_array('4', $daysarray)) checked @endif>
                                <label for="vehicle1"> 木</label>
                                <input type="checkbox" style="margin-left: 3%;" id="vehicle1" name="days[]" value="5" @if (isset($daysarray) && is_array($daysarray) && in_array('5', $daysarray)) checked @endif>
                                <label for="vehicle1"> 金</label>

                            </div>
                            <div class="col-md-4" style="padding-bottom: 35px;text-align: left;padding-left: 14%; display: none">
                                <label class="bmd-label-floating" style="margin-top: 42px;">自動終了金額指定</label>
                            </div>
                            <div class="col-md-8 pl-4" style="display: none">
                                <div class="row" style="border: 1px solid black;width:75%;background: #C0C0C0;">
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 勝金額 </p>
                                    </div>
                                    <div class="col-md-4" style="padding: 5px;">
                                        <input type="number" min="0" class="form-control" style="background: white;text-align:center;" name="winningamount">
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
                                        <input type="number" min="0" class="form-control" style="background: white;text-align:center;" name="negativeamount">
                                    </div>
                                    <div class="col-md-4">
                                        <p style="margin-top: 6px;"> 倍 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="" style="margin: auto;">
                                    <button class="btn" style="margin: 0; padding: 0; width: 150px; height: 35px" {{ (count($client) == 0 ? 'disabled': '') }}>Submit</button>
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
