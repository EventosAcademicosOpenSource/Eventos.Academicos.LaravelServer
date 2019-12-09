@extends('admin.layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.eventos.index') }}">Lista de Eventos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista de Eventos Integrantes</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                <h5 class="my-0 font-weight-normal text-center">Evento integrante para -> {{ $event->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <a class="btn btn-danger" href="{{ route('admin.eventChildrenNoSpeaker.create', $event->id) }}" role="button">Novo Evento Integrante</a>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    @if ($childrenEvents->count() > 0)
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped bg-white">
                <thead>
                    <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Local</th>
                    <th scope="col">Data/Hora Inicial</th>
                    <th scope="col">Data/Hora Final</th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($childrenEvents as $children)
                    <tr>
                        <th>{{ $children->name }}</th>
                        <th>{{ $children->local }}</th>
                        <td>{{ $children->dateStart. ' '. $children->hourStart . 'h' }}</td>
                        <td>{{ $children->dateEnd. ' '. $children->hourEnd . 'h' }}</td>
                        <td><a class="btn btn-info" href="{{ route('admin.eventChildrenNoSpeaker.edit',['id' => $children->id, 'idEvent' => $event->id]) }}">Editar</a></td>
                        <td>
                            <form action="{{ route('admin.eventChildrenNoSpeaker.destroy', $children->id)}}" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este Evento Integrante?');">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit"  class="btn btn-danger" role="button" />Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row align-items-center justify-content-center">
            {{ $childrenEvents->links() }}
        </div>
    </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre um novo Evento Integrante</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem Eventos Integrantes cadastrados.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection