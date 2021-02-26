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

                <h2>自動 BET 設定</h2>
                <div class="row">
                    <div class="col-md-8" style="margin: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="javascript:;" class="btn btn-primary btn-round" style="width: 100%"; onclick="goBack()"><b>グループ設定 </b></a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:;" class="btn btn-primary btn-round" style="width: 100%"; onclick="goBack()">個人設定</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row pt-3">
                <div class="col-md-6">
                    <h3 style="text-align: center";>グループ一覧</h3>
                </div>
                <div class="col-md-6">
                    <h3>新規グループ作成</h3>
                </div>
            </div>
            <div class="row pt-3 pb-5">
                <table class="table col-md-8" id="table">

                    <thead class=" text-primary">
                        <th> 作成日  </th>
                        <th class="" style="text-align: left";> グループ名   </th>
                        <th> 自動設定 </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20201117  </td>
                            <td class="" style="text-align: left";>Group A  </td>
                            <td>編集 / 削除</td>
                        </tr>
                        <tr>
                            <td>20201118 </td>
                            <td class="" style="text-align: left";>Group B  </td>
                            <td>編集 / 削除</td>
                        </tr>
                        <tr>
                            <td>20201119 </td>
                            <td class="" style="text-align: left";>Group C </td>
                            <td>編集 / 削除</td>
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