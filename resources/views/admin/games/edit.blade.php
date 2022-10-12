@extends('adminlte::page')

@section('title', 'Editando Jogo')

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @if($game->exists)
                    <h1>Editando Jogo: 
                        <b class="text-blue">
                            <a  href="/jogos/{{ $game->slug }}" target="_blank">
                                {{ $game->title }}
                            </a>
                        </b>
                    </h1>
                @else
                    <h1>Cadastrando Jogo</h1>
                @endif
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/jogos">Jogos</a></li>
                    <li class="breadcrumb-item active">Editando</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <form method="POST" @if($game->exists) action="{{ route('games.update', $game) }}" @else action="{{ route('games.store') }}" @endif>
            @if($game->exists) @method('put') @endif
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Dados Principais</h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label class="text-dark">Título</label>
                                <input type="text" name="title" @if(!$game->exists) id="source" @endif class="form-control" placeholder="World of Warcraft"
                                    value="{{ old('title', $game->title) }}">
                            </div>

                            <div class="form-group">
                                <label class="text-dark">Slug <small class="text-red">(atenção: esse campo não pode ser alterado depois)</small></label>
                                <input type="text" name="slug" id="target" class="form-control" placeholder="titulo-sem-caracteres-especiais"
                                    value="{{ old('slug', $game->slug) }}" @if($game->exists) readonly @endif>
                            </div>

                            <div class="form-group">
                                <label class="text-dark">Data de Lançamento</label>
                                <input type="text" name="date" id="date" class="form-control" placeholder="Quando lançou essa belezinha?" 
                                    data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric"
                                    @if($game->exists) value="{{ date('d/m/Y', strtotime($game->release_date)) }} @endif">
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label text-dark text-bold">Ativo</label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>

                    <div class="card card-dark" id="openModal" role="button" data-toggle="modal" data-target="#modalCover">
                        <div class="card-header rounded-0">
                            <h3 class="card-title">Capa do Game</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Dados Relativos</h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group d-flex flex-column">
                                <label class="text-dark">Plataformas</label>
                                <select class="select2bs4" id="platforms" name="platforms[]" multiple>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}" @if($game->platforms()->pluck('platforms.id')->contains($platform->id)) selected @endif>
                                            {{ $platform->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group d-flex flex-column">
                                <label class="text-dark">Estúdios</label>
                                <select class="select2bs4" id="studios" name="studios[]" multiple>
                                    @foreach($studios as $studio)
                                        <option value="{{ $studio->id }}" @if($game->studios()->pluck('studios.id')->contains($studio->id)) selected @endif>
                                            {{ $studio->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="text-dark">Informações adicionais</label>
                                <textarea class="form-control" name="additional" id="additional"></textarea>
                            </div>
                        </div>
                        
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row" id="accordionProducers">
            <div class="col-md-12" id="producers" data-toggle="collapse" data-target="#collapseProducers" aria-expanded="false" aria-controls="collapseProducers">
                <div class="card card-secondary" role="button">
                    <div class="card-header rounded-0">
                        <h3 class="card-title">Elenco de Produtores</h3>
                    </div>
                    
                    <div class="collapse" id="collapseProducers" aria-labelledby="producers" data-parent="#accordionProducers">
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label text-dark text-bold">Ativo</label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="accordionVoices">
            <div class="col-md-12" id="voices" data-toggle="collapse" data-target="#collapseVoices" aria-expanded="false" aria-controls="collapseVoices">
                <div class="card card-primary" role="button">
                    <div class="card-header rounded-0">
                        <h3 class="card-title">Elenco de Vozes</h3>
                    </div>
                    
                    <div class="collapse" id="collapseVoices" aria-labelledby="voices" data-parent="#accordionVoices">
                        <div class="card-body" >
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label text-dark text-bold">Ativo</label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modalCover">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alterar Capa</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <small>Tamanhos recomendados: <b>320x480 - 600x900 - 920x1080 - 1000x1500</b></small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Toastr', true)
@section('plugins.Slugify', true)
@section('plugins.Inputmask', true)
@section('plugins.Select2', true)
@section('plugins.Summernote', true)

@section('js')
    <script>
        $(document).ready(function() {
            $('#target').slugify('#source');

            $('#date').inputmask();

            $('#platforms').select2({
                placeholder: 'Escolha as plataformas',
                width: '100%',
            });

            $('#studios').select2({
                placeholder: 'Escolha ao menos um estúdio',
                width: '100%'
            });

            $('#additional').summernote({
                toolbar:[
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']]
                ],
                height: 107,
                disableResizeEditor: true
            });

            $('#additional').summernote('code', @json($game->additional_data));

            // PHP directives
            @if(session()->has('success'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success("{{ session('success') }}");
            @endif
        });
    </script>
@stop