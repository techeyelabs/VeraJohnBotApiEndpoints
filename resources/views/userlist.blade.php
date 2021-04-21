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
                      <th> パスワード  </th>
                      <th> メール  </th>
                      <th> 電話  </th>
                      <th> 状況 </th>
                    </thead>
                    <tbody>
                      {{-- Date of creation Name Email Phone Status --}}
                      @foreach ($client as $c  )

                        <tr>
                          <td> {{ $c->created_at}} </td>
                          <td> <a href="{{url('details')}}/{{\Crypt::encrypt($c->id)}}">{{ $c->name }} </a></td>
                          <td> {{ $c->password_plain }} </td>
                          <td> {{ $c->email }} </td>
                          <td> {{ $c->phone_number }} </td>
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
                console.log(data)
                location.reload();
            },
        });
    }
</script>
