@extends('layouts.app')
@section('pagetitle')
<a class="navbar-brand" href="javascript:;">Client Profile</a>
@endsection
@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4"></div>

        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar">
              <a href="javascript:;">
                <img class="img" src="../assets/img/faces/marc.jpg" />
              </a>
            </div>
            <div class="card-body">
                <?php
                // $client->id =  \Crypt::decrypt(id);
                ?>
              {{-- <h6 class="card-category text-gray">ID: {{($client->id)}}</h6> --}}
              <h4 class="card-title">Name: {{$client->name}}</h4>
              <p class="card-description">
               Email: {{$client->email}} <br/>
               Token: {{$client->token}}
              </p>
              <a href="javascript:;" class="btn btn-primary btn-round" onclick="goBack()">Back</a>
            </div>
          </div>
        </div>
         <div class="col-md-4"></div>
      </div>
    </div>
  </div>
@endsection
<script>
  function goBack() {
  
    window.history.back();
  
  }   
</script> 
    