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

                <h4>自動 BET 設定</h4>
                <div class="row" style="display: none">
                    <div class="col-md-8" style="margin: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{url('automatebet')}}" class="btn btn-primary btn-round" style="width: 100%;"><b>グループ設定 </b></a>
                            </div>
                            <div class="col-md-6">
                                {{-- <a href="{{url('personal_settings')}}" class="btn btn-primary btn-round" style="width: 100%";>個人設定</a> --}}
                                <a href="{{url('nogroup_users')}}" class="btn btn-primary btn-round" style="width: 100%";>個人設定</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row pt-5">
                <div class="col-md-6">
                    <a style="font-size: 20px;">グループ一覧</a>
                </div>
                <div class="col-md-6">
                    <a style="font-size: 20px;" href="{{url('creategroup')}}">新規グループ作成</a>
                </div>
            </div>
            <div class="col-md-8 pt-5 pb-5" style="margin: auto;">
                <table class="table" id="table">

                    <thead class=" text-primary">
                        <th> 作成日  </th>
                        <th class="" style="text-align: left";> グループ名   </th>
                        <th> 自動設定 </th>
                    </thead>
                    <tbody>
                        @foreach ($data as $dt )
                            <tr>
                                <td>{{ $dt->created_at }} </td>
                                <td style="text-align: left;"><a href="{{url('personal_list')}}/{{\Crypt::encrypt($dt->id)}}">{{ $dt->group_name }}</a></td>
                                <td><a href="{{url('edit_group')}}/{{\Crypt::encrypt($dt->id)}}">編集</a> / <a href="javascript:del('{{$dt->id}}')"> 削除</a></td>
                            </tr>
                        @endforeach
                        {{-- <td>20201117  </td>
                        <td class="" style="text-align: left";>Group A  </td>
                        <td>編集 / 削除</td> --}}

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

<script>
    function del(id){
        if (confirm("本気ですか？")){
            var ajaxurl = "{{route('delete_group')}}";
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
    }
</script>

