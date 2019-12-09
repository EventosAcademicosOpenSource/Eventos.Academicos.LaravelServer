@extends('admin.layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.eventos.index') }}">Lista de Eventos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastro de Patrocinadores no Evento</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                <h5 class="my-0 font-weight-normal text-center">Patrocinadores para o Evento {{ $event->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" action="{{ route('admin.eventSponsors.store') }}">
                                {!! csrf_field() !!}
                                <div class="form-row">
                                    <div class="col-md-12 mb-2 mt-2">
                                        <select class="custom-select" id="select" name="sponsor_id" required>
                                            @if($sponsors->count() > 0)
                                                <option value="">Selecione o Patrocinador</option>  
                                                @foreach ($sponsors as $sponsor)
                                                        <option value="{{ $sponsor->id}}">{{ $sponsor->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">SEM PATROCINADORES CADASTRADOS - Cadastre um PATROCINADOR</option>
                                            @endif
                                        </select>
                                    </div>
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <button class="btn btn-primary btn-block" type="submit">SALVAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    @if ($eventSponsors->count() > 0)
    <div class="col-md-12">
        @foreach ($eventSponsors as $sponsor)
            <div class="row animated bounceInLeft my-2">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <p class="card-text">
                                <b>Patrocinador:</b> {{ $sponsor->name }}<br/>
                                <br/><b>E-mail:</b>  {{ $sponsor->email }}
                            </p>
                            <hr>
                            <div class="row">
                                <form action="{{ route('admin.eventSponsors.destroy', ['id' => $event->id, 'idPatrocinador' => $sponsor->id]) }}" class="mt-3" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn bg-danger btn-sm text-white" />Deletar</button>
                            </form>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre um patrocinador</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem patrocinadores.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#select').select2();
        });
    </script>
@endsection