@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal text-center">Usuários</h4>
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col-auto"><a class="btn btn-danger" href="{{ route('admin.users.create')}}" role="button">Novo Usuário</a></div>
                </div>
            </div>
            </div>
        </div>  
    </div>
    <div class="panel-body bg-white">
        @if ($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col" style="width:80%">Nome</th>
                    <th scope="col" style="width:14%">Email</th>
                    <th scope="col" style="width:3%"></th>
                    <th scope="col" style="width:3%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><a class="btn btn-warning text-white" href="{{ route('admin.users.edit', $user->id) }}">Editar</a></td>
                            <td>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" class="" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este usuário?')">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" />Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row align-items-center justify-content-center">
        {!! $users->links() !!}
        </div>
    </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre Usuários</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem usuários cadastrados.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
    <!-- <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-acess-tokens></passport-personal-acess-tokens> -->
@endsection