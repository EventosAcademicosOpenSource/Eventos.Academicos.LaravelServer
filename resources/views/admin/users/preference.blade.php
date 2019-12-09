@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
            <div class="card border-info mb-3">
                <div class="card-header">Informação</div>
                <div class="card-body text-info">
                    <p class="card-text">Se a senha ficar em branco ela continuará a mesma.</p>
                </div>
            </div>
            <div class="card box-shadow">
                <div class="card-header">
                <h4 class="my-0 font-weight-normal text-center">Preferência do Usuário</h4>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <form method="POST" action="{{ route('admin.user.update') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <div class="form-row">
                                <div class="col-md-5 mb-2">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name  }}" required>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="password_confirmation">Confirme a senha</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block" type="submit">SALVAR</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection