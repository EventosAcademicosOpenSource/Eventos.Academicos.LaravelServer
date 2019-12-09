@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal text-center">Patrocinadores</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-8">
                        <form method="GET" action="{{ route('admin.patrocinadores.search') }}" accept-charset="UTF-8">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" name="search" class="form-control" id="search" placeholder="Nome do Patrocinador" value="{{ !(isset($search)) ? "" : $search }}">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-outline-primary mb-2">Pesquisar</button>
                                </div>
                            </div>
                            @if (isset($search))
                                <a href="{{ route('admin.patrocinadores.index') }}" class="mb-2 ml-3 btn btn-success">Cancelar pesquisa</a>
                            @endif
                        </form>
                <div class="float-left"><a class="btn btn-danger" href="{{ route('admin.patrocinadores.create') }}" role="button">Novo Patrocinador</a></div>
                </div>
            </div>
        </div>
    </div> 
    @if ($sponsors->count() > 0)
        @foreach ($sponsors->chunk(3) as $items)
        <div class="row animated bounceInLeft my-2 card-deck mx-auto">
             @foreach($items as $sponsor)
                <div class="card cardHover" style="max-width: 21rem;">
                    @if($sponsor->image)
                        <img src="{{ $sponsor->photo_full_url }}" class="card-img-top" alt="{{ $sponsor->name }}">
                    @else
                        <img class="card-img-top" src="http://via.placeholder.com/286x180" alt="Sem imagem">
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $sponsor->name }}</h5>
                        <p class="card-text">{{ $sponsor->email }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="" role="group">
                            <div class="dropdown dropup">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a href="{{ route('admin.patrocinadores.edit', $sponsor->id) }}" class="dropdown-item">Editar</a>
                                    <form action="{{ route('admin.patrocinadores.destroy', $sponsor->id)}}" class="" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este Patrocinador?')">
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
        {{ $sponsors->links() }}
        </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre Patrocinadores</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem patrocinadores cadastrados.</p>
                        <a href="{{ route('admin.patrocinadores.create') }}" class="btn btn-primary">Cadastrar Patrocinador</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection