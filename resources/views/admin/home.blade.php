@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card-deck mb-3 justify-content-center">
        <div class="col-md-8">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Dashboard</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">Bem vindo {{ Auth::user()->name }}</h1>
          </div>
        </div></div>
    </div>
</div>
@endsection
