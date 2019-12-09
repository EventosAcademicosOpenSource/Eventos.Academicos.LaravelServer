@extends('admin.layouts.app')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.eventos.index') }}">Lista de Eventos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastro de notificações</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card-deck mb-3">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                <h5 class="my-0 font-weight-normal text-center">Notificações para o Evento {{ $event->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" action="{{ route('admin.notification.store') }}">
                                {!! csrf_field() !!}
                                <div class="form-row">
                                    <div class="col-md-12 mb-2">
                                        <label for="title">Título</label>
                                        <input type="text" class="form-control" id="name" name="title" value="{{ old('title') }}" required>
                                        <div id="textarea_feedback"></div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="message">Mensagem</label>
                                        <input type="text" class="form-control" id="message" name="message" value="{{ old('message') }}" required>
                                        <div id="messageText"></div>
                                    </div>
                                    <input type="hidden" name="eventId" value="{{ $event->id }}">
                                    <button class="btn btn-primary btn-block" type="submit">SALVAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    @if ($notifications->count() > 0)
    <div class="col-md-12">
        @foreach ($notifications as $not)
            <div class="row animated bounceInLeft my-2">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Título: {{ $not->title }}</h5>
                            <p class="card-text">
                                <b>Mensagem:</b> {{ $not->message }}<br/>
                                <br/><b>Data de emissão:</b>  {{ $not->dateNotification }}
                            </p>
                        </div>
                    </div>     
                </div>
            </div>
        @endforeach
        <div class="row align-items-center justify-content-center">
            {{ $notifications->links() }}
        </div>
    </div>
    @else
        <div class="row">
            <div class="mx-auto">
                <div class="card text-center border-info ">
                    <h5 class="card-header">Cadastre uma notificação</h5>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Sem notificações.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var text_max = 150;
            $('#textarea_feedback').html(text_max + ' caracteres restantes');
            $('#name').keyup(function() {
                var text_length = $('#name').val().length;
                var text_remaining = text_max - text_length;
                $('#textarea_feedback').html(text_remaining + ' caracteres restantes');
            });
            $('#messageText').html(text_max + ' caracteres restantes');
            $('#message').keyup(function() {
                var text_length = $('#message').val().length;
                var text_remaining = text_max - text_length;
                $('#messageText').html(text_remaining + ' caracteres restantes');
            });
        });
    </script>
@endsection