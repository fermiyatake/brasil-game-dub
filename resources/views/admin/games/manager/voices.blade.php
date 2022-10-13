@extends('adminlte::page')

@section('title', 'Elenco de Vozes')

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Vozes: 
                    <b class="text-blue">
                        <a  href="/jogos/{{ $game->slug }}" target="_blank">
                            {{ $game->title }}
                        </a>
                    </b>
                </h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/jogos">Jogos</a></li>
                    <li class="breadcrumb-item"><a href="/admin/jogos/{{ $game->id }}">{{ $game->title }}</a></li>
                    <li class="breadcrumb-item active">Vozes</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        @if($game->exists)
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-secondary">
                        <div class="card-header rounded-0">
                            <h3 class="card-title">Elenco de Vozes</h3>
                        </div>
                        
                        <form method="POST" action="#" id="voiceForm">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="d-flex justify-content-between" id="buttons">
                                    <button type="submit" class="btn btn-primary">Salvar</button>

                                    <div class="custom-control custom-switch ml-2 d-flex" style="align-items: center">
                                        <input type="checkbox" class="custom-control-input" id="lock" checked>
                                        <label class="custom-control-label" for="lock">Proteção</label>
                                    </div>
                                    
                                    <div class="actions">
                                        <button id="add" class="btn btn-secondary" type="button"><i class="fa fa-plus"></i></button>
                                        <button id="up" class="btn btn-secondary" type="button"><i class="fa fa-caret-up"></i></button>
                                        <button id="down" class="btn btn-secondary" type="button"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                                
                                <table class="table table-bordered mt-3" id="voiceTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 12px;"></th>
                                            <th>Personagem</th>
                                            <th>Dublador</th>
                                            <th>Grupo</th>
                                        </tr>
                                    </thead>

                                    <tbody id="roles">
                                        @forelse($game->voices as $voice)
                                            <tr class="role">
                                                <td class="align-middle">
                                                    <input type="radio" name="selected" class="selected" tabindex="-1">
                                                </td>

                                                <td class="character">
                                                    <input type="text" class="form-control" name="character[]" value="{{ $voice->character }}" required>
                                                </td>

                                                <td>
                                                    <select class="form-control professional" name="professional[]"> 
                                                        <option value=""></option>
                                                        <option value="{{ $voice->professional->id }}" selected>{{ $voice->professional->name }}</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control" name="group[]" value="{{ $voice->section_name }}">
                                                </td>

                                                <td class="text-center align-middle remover" style="width: 4.5rem">
                                                    <button type="button" class="btn btn-xs btn-danger remove action" tabindex="-1">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-xs btn-success add action" tabindex="-1">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

@section('js')
    @include('admin.messages')

    <script>
        $(document).ready(function() {
            let options = populate(@json($professionals));

            $(document).on('click', '#add', function() { add(options) });
            $(document).on('click', '#up', function() { move('up')});
            $(document).on('click', '#down', function() { move('down')});

            $(document).on('click', '.add', function() { addAfter(this, options) });
            $(document).on('click', '.remove', function() { remove(this) });

            $('.professional').append(options);
        });
    </script>

    <script src="/js/voice.manager.js"></script>
@stop