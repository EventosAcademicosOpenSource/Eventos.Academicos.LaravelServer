<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
            color: #007bff;
        }
        .note-editable {
            line-height: 1;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel box-shadow border-bottom bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home')}}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @auth
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {!! (Request::is('*home') ? 'active' : '') !!}" >
                        <a class="nav-link" href="{{ route('home')}}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item {!! (Request::is('*usuarios*') ? 'active' : '') !!}">
                            <a class="nav-link" href="{{ route('admin.users.index')}}">Usuários</a>
                        </li>
                        <li class="nav-item {!! (Request::is('*palestrantes*') ? 'active' : '') !!}">
                            <a class="nav-link" href="{{ route('admin.palestrantes.index')}}">Palestrantes</a>
                        </li>
                        <li class="nav-item {!! (Request::is('*patrocinadores*') ? 'active' : '') !!}">
                            <a class="nav-link" href="{{ route('admin.patrocinadores.index')}}">Patrocinadores</a>
                        </li>
                        <li class="nav-item {!! (Request::is('*eventos*') ? 'active' : '') !!}">
                            <a class="nav-link" href="{{ route('admin.eventos.index')}}">Eventos</a>
                        </li>
                    </ul>   

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="btn btn-outline-primary" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('admin.user.index') }}">
                                        Conta
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    @endauth
                </div>
            </div>
        </nav>
         @auth
        @if ($errors->any())
            <div class="alert alert-danger animated fadeInUp alert-dismissible fade show">
                <button class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
                <div class="clearfix"></div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flash-message animated fadeIn">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif @endforeach
        </div>
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/moment.js') }}"></script>
    <script src="{{ mix('js/daterangepicker.js') }}"></script>
    <link href="{{ asset('js/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <script src="{{ asset('js/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/summernote/lang/summernote-pt-BR.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $('.selecao-arquivo').on("change", function(e){
            $('#selecao').text(e.currentTarget.files[0].name);
        });
        function previewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("selecao-arquivo").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").style.height = "200px";
                document.getElementById("uploadPreview").style.height = "300px";
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            };
        };
        $('#comment').summernote({
            height: 300,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize','fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['misc', ['codeview', 'undo', 'redo']],
                ],
            disableDragAndDrop: true,
            lang: 'pt-BR',
        });
    </script> 
    @yield('script')
</body>
</html>
