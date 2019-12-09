@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal text-center">Eventos Principais Cadastrados</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.eventos.search') }}" accept-charset="UTF-8">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="text" name="search" class="form-control" id="search" placeholder="Pesquise por nome do evento" value="{{ !(isset($search)) ? "" : $search }}">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-outline-primary mb-2">Pesquisar</button>
                            </div>
                        </div>
                        @if (isset($search))
                        <div class="float-right">
                            <a href="{{ route('admin.eventos.index') }}" class="mb-2 ml-3 btn btn-success">Cancelar pesquisa</a>
                        </div>
                        @endif
                    </form>
                    <div class="float-left"><a class="btn btn-danger" href="{{ route('admin.eventos.create') }}" role="button">Novo Evento</a></div>
                </div>
            </div>
        </div>  
    </div>
    @if ($events->count() > 0)
    <div class="col-md-12">
        @foreach ($events as $event)
            <div class="row animated bounceInLeft my-2">
                <div class="col-md-12">
                <div class="card mb-3">
                    @if($event->image)
                        <img class="card-img-top" src="{{ $event->photo_thumb }}" alt="{{ $event->name }}" style="width: 100%; height:50%;">
                    @else
                        <img class="card-img-top" src="http://via.placeholder.com/600x150" alt="{{ $event->name }}" style="width: 100%; height:50%;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">Nome: {{ $event->name }}</h5>
                        <p class="card-text">
                            <br/><b>Local:</b> {{ $event->local }}
                            <br/><b>Data:</b> {{ $event->dateStart }} - {{ $event->dateEnd }}
                            <br/><b>Hora:</b> {{ $event->hourStart }}h - {{ $event->hourEnd }}h
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="" role="group">
                            <div class="dropdown dropup">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a href="{{ route('admin.notification.index', $event->id) }}" class="dropdown-item" title="Cadastre notificações para este evento" data-toggle="tooltip" data-placement="top">Notificar</a>
                                    <a href="{{ route('admin.eventChildren.index', $event->id) }}" class="dropdown-item"  title="Cadastre palestras para este evento" data-toggle="tooltip" data-placement="top">Palestras</a>
                                    <a href="{{ route('admin.eventChildrenNoSpeaker.index', $event->id) }}" class="dropdown-item"  title="Cadastre evento integrante neste evento" data-toggle="tooltip" data-placement="top">Evento Integrante</a>
                                    <a href="{{ route('admin.eventSponsors.index', $event->id) }}" class="dropdown-item" title="Cadastre patrocinadores para este evento" data-toggle="tooltip" data-placement="top">Patrocinadores</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('admin.eventos.edit', $event->id) }}" class="dropdown-item" title="Edite este evento principal" data-toggle="tooltip" data-placement="top">Editar</a>
                                    <form action="{{ route('admin.eventos.destroy', $event->id)}}" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este Evento Principal e seus Eventos Filhos?');">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="dropdown-item">Deletar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
        @endforeach
        <div class="row align-items-center justify-content-center">
        {{ $events->links() }}
        </div>
    </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre um Evento Principal</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem Eventos Principais cadastrados.</p>
                        <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">Cadastrar Evento</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection