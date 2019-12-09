@extends('admin.layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.patrocinadores.index') }}">Lista de Patrocinadores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Patrocinador</li>
        </ol>
    </nav>
    <div class="justify-content-center">
            <div class="card box-shadow">
                <div class="card-header">
                <h4 class="my-0 font-weight-normal text-center">Patrocinador {{ $sponsor->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <form method="POST" action="{{ route('admin.patrocinadores.update', $sponsor->id) }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            {!! Form::hidden('id', $sponsor->id) !!}
                            <div class="form-row">
                                <div class="col-md-5 mb-2">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $sponsor->name  }}" required>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $sponsor->email }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="link">Link (Site)</label>
                                    <input type="text" class="form-control" id="link" name="link" value="{{ $sponsor->link  }}">
                                </div>
                            </div>
                            <div class="text-center">
                                @if($sponsor->image)
                                    <label>Foto Atual</label>
                                    <img src="{{ $sponsor->photo_full_url  }}" class="img-thumbnail" alt="{{ $sponsor->name }}" style="width: 300px;height: 200px;">
                                @else
                                    <h5>Sem imagem</h5>
                                @endif
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