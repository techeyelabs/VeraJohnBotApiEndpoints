@extends('layouts.app')
@section('custom_css')

@endsection
@section('pagetitle')
  <a class="navbar-brand" href="javascript:;"></a>
@endsection

@section('content')
  <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">ユーザー一覧</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table" id="table">
                    <thead class=" text-primary">
                      <th > 作成日  </th>
                      <th data-field="github.name" data-sortable="true"> 氏名  </th>
                      <th> メール  </th>
                      <th> 電話  </th>
                      <th> 状況 </th>
                    </thead>
                    <tbody>
                      {{-- Date of creation Name Email Phone Status --}}
                      @foreach ($client as $c  )
                    
                        <tr>
                          <td> <a href="{{url('details')}}/{{\Crypt::encrypt($c->id)}}">{{ $c->created_at}} </a></td>
                          <td> <a href="{{url('details')}}/{{\Crypt::encrypt($c->id)}}">{{ $c->name }} </a></td>
                          <td> <a href="{{url('details')}}/{{\Crypt::encrypt($c->id)}}">{{ $c->email }} </a></td>
                          <td class="text-primary"> <a href="{{url('details')}}/{{\Crypt::encrypt($c->id)}}">{{ $c->phone_number }} </a></td>
                          {{-- <td><button class="btn btn-round btn-primary ">Enable</button></td> --}}
                          <td> @if($c->status==1)
                                <button type="submit" class="btn btn-white btn-round btn-just-icon" style="background-color: #b3cfe8;" onclick="doAjax({{$c->id}})" >
                                  <i class="material-icons" style="color:black;">lock_open</i>
                                  <div class="ripple-container"></div>
                                </button>
                              @elseif($c->status==0)
                                <button type="submit" class="btn btn-white btn-round btn-just-icon" style="background-color: #b3cfe8;"  onclick="doAjax({{$c->id}})">
                                  <i class="material-icons" style="color:black;">lock</i>
                                  <div class="ripple-container"></div>
                                </button>
                              @endif
                              <a href="{{url('user-details')}}/{{\Crypt::encrypt($c->id)}}">
                              <button type="submit" class="btn btn-white btn-round btn-just-icon" style="background-color: #b3cfe8;" >
                                <i class="material-icons" style="color:black;">remove_red_eye</i>
                                <div class="ripple-container"></div>
                              </button></a>
                              <button type="submit" class="btn btn-white btn-round btn-just-icon" style="background-color: #b3cfe8;"  onclick="">
                                <i class="material-icons" style="color:black;">print</i>
                                <div class="ripple-container"></div>
                              </button>
                          </td>
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
    </div>
@endsection
<script>
  function doAjax(id) {
    
    var ajaxurl = "{{route('change-user-status')}}";
    
    $.ajax({
        url: ajaxurl,
        type: "GET",
        data: {
                '_token': "{{ csrf_token() }}",
                'id': id
        },
        success: function(data){
            location.reload();
        },
    });
  }
</script>
