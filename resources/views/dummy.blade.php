@extends('layouts.app')
@section('pagetitle')
<a class="navbar-brand" href="javascript:;"></a>
@endsection


@section('content')
    <div class="content">
        <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="row">
                    <h3 style="margin: 0 auto;">Bet History</h3>
                    <table class="table col-md-8" id="table">
                        <thead class=" text-primary">
                            <th> 日付  </th>
                            <th> 金額  </th>
                        </thead>
                        <tbody>
                            @foreach ($details as $d  )
                                <tr>
                                    <td>{{ $d->created_at }} </td>
                                    <td>{{ $d->aftermath }}</td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td>2020/11/20 </td>
                                <td>$350.00</td>
                            </tr>
                            <tr>
                                <td>2020/11/20 </td>
                                <td>$350.00</td>
                            </tr>
                            <tr>
                                <td>2020/11/20 </td>
                                <td>$350.00</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        </div>
    </div>
@endsection


<form action="{{route('create-user-action')}}" method="POST" id="logForm">
    {{ csrf_field() }}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row"> 
        <div class="col-md-12">
            <div class="form-group">
                <label class="bmd-label-floating">お名前 </label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary pull-right">登録する</button>
    <div class="clearfix"></div>
</form>