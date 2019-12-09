@extends('admin.layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.eventos.index') }}">Lista de Eventos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastro de Evento</li>
        </ol>
    </nav>
    <div class="justify-content-center">
            <div class="card box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal text-center">Evento</h4>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <form method="POST" action="{{ route('admin.eventos.store') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="form-row">
                                <div class="col-md-5 mb-2">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label for="local">Local</label>
                                    <input type="text" class="form-control" id="local" name="local" value="{{ old('local') }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="link">Link (Site)</label>
                                    <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment">Breve descrição</label>
                                <textarea class="form-control" rows="5" id="comment" name="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="text-center">
                                <img id="uploadPreview" class="img-thumbnail">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Foto</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input selecao-arquivo"  accept="image/*" id="selecao-arquivo" name="image" onchange="previewImage();">
                                    <label class="custom-file-label" for="selecao-arquivo" id="selecao">Escolha o arquivo</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button" id="dateStart" title="Selecione as data-hora iniciais e finais" data-toggle="tooltip" data-placement="top">Data e Hora do evento</button>
                                    </div>
                                    <input type="text" class="form-control" id="dataInicial" name="date_time" readonly value="{{ old('date_time') }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-3 mb-2">
                                    <label for="checkbox2">Publicar</label>
                                    <input type="checkbox" class="mb-2" name="publish" checked="checked" value="1" id="checkbox2">
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
@section('script')
    <script>
        $('#comment').summernote({
            height: 300,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link','video']],
                ['misc', ['codeview']]
                ],
            popover: {
                air: [
                ['color', ['color']],
                ['font', ['bold', 'underline', 'clear']]
                ]
            },
            lang: 'pt-BR'
        });
        $('#dateStart').daterangepicker({
            "minDate": "{{ $dateStart }}",
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerIncrement": 5,
            "locale": {
                "format": "DD/MM/YYYY h:mm A",
                "separator": " - ",
                "applyLabel": "Salvar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Para",
                "toLabel": "De",
                "weekLabel": "S",
                "daysOfWeek": [
                    "D",
                    "S",
                    "T",
                    "Q",
                    "Q",
                    "S",
                    "S"
                ],
                "monthNames": [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
                "firstDay": 1
            },
            "drops": "up"
        }, function(start, end, label) {
            $('#dataInicial').val('' + start.format('DD/MM/YYYY HH:mm') + ' - ' + end.format('DD/MM/YYYY HH:mm'));
        });
    </script>
@endsection