@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal text-center">Palestrantes</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-6 col-md-8">
                    <form method="GET" action="{{ route('admin.palestrantes.search') }}" accept-charset="UTF-8">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="text" name="search" class="form-control" id="search" placeholder="Nome do Palestrante" value="{{ !(isset($search)) ? "" : $search }}">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-outline-primary mb-2">Pesquisar</button>
                            </div>
                        </div>
                        @if (isset($search))
                        <div class="float-right">
                            <a href="{{ route('admin.palestrantes.index') }}" class="mb-2 ml-3 btn btn-success">Cancelar pesquisa</a>
                        </div>
                        @endif
                    </form>
                    <div class="float-left"><a class="btn btn-danger" href="{{ route('admin.palestrantes.create') }}" role="button">Novo Palestrante</a></div>
                </div>
            </div>
        </div>
    </div> 
    @if ($speakers->count() > 0)
        @foreach($speakers->chunk(3) as $items)
        <div class="row animated bounceInLeft my-2 card-deck mx-auto">
            @foreach($items as $speak)
                <div class="card cardHover" style="max-width: 21rem;">
                    @if($speak->image)
                        <img src="{{ $speak->photo_full_url }}" class="card-img-top" alt="{{ $speak->name }}">
                    @else
                        <img class="card-img-top" src="http://via.placeholder.com/286x180" alt="Sem imagem">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $speak->name }}</h5>
                        <p class="card-text">{{ $speak->email }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="" role="group">
                            <div class="dropdown dropup">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a href="{{ route('admin.palestrantes.edit', $speak->id) }}" class="dropdown-item">Editar</a>
                                    <form action="{{ route('admin.palestrantes.destroy', $speak->id)}}" class="" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este Palestrante?')">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="dropdown-item">Deletar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endforeach
    <div class="row align-items-center justify-content-center">
    {{ $speakers->links() }}
    </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre Palestrantes</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem palestrantes cadastrados.</p>
                        <a href="{{ route('admin.palestrantes.create') }}" class="btn btn-primary">Cadastrar Palestrante</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection