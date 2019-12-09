@extends('admin.layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.palestrantes.index') }}">Lista de Palestrante</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastro de Palestrante</li>
        </ol>
    </nav>
    <div class="justify-content-center">
            <div class="card box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal text-center">Palestrante</h4>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <form method="POST" action="{{ route('admin.palestrantes.store') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="form-row">
                                <div class="col-md-5 mb-2">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="link">Link (Curriculo ou Site)</label>
                                    <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comment">Breve Histórico</label>
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
                            <button class="btn btn-primary btn-block" type="submit">SALVAR</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection