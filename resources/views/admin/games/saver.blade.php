<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" integrity="sha512-ZfKn7az0YmtPUojZnRXO4CUdt3pn+ogBAyGbqGplrCIR5B/tQwPGtF2q29t+zQj6mC/20w4sSl0cF5F3r0HKSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 50%; 
            height: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        input, select {
            font-size: 14px;
        }

        input, input:focus, input:focus-visible {
            border: none;
            outline: none;
        }

        select {
            width: 100%;
            height: 100%;
            outline: none;
            border: none;
        }

        .character, .group {
            cursor: text;
        }

        .remover {
            display: contents;
        }

        .action {
            background: white;
            border: none;
            height: 100%;
            margin: 0 1rem;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <button id="add" class="add action" type="button">+</button>
    <button id="up" type="button"><i class="fa fa-caret-up"></i></button>
    <button id="down" type="button"><i class="fa fa-caret-down"></i></button>
    <button id="save" type="button">Salvar</button>
    <input type="checkbox" id="lock" checked> Proteção

    <br><br>

    <form method="POST" action="/saver" id="formRole">
        @csrf
        <table id="table">
            <tr>
                <td></td>
                <th>Personagem</th>
                <th>Profissional</th>
                <th>Grupo</th>
            </tr>

            <tbody id="roles">
                @if(!$game->voices)
                    <tr id="master" class="role">
                        <td><input type="radio" name="selected" class="selected"></td>
                        <td class="character"><input type="text" name="personagem[]"></td>
                        <td><select class="profissional" name="profissional[]"><option></option></select></td>
                        <td class="group"><input type="text" name="grupo[]"></td>
                        <td class="remover"><button type="button" class="remove action"><i class="fa fa-trash"></i></button></td>
                    </tr>
                @else
                    @foreach($game->voices as $voice)
                        <tr id="master" class="role">
                            <td>
                                <input type="radio" name="selected" class="selected">
                            </td>

                            <td class="character">
                                <input type="text" name="personagem[]" value="{{ $voice->character }}">
                            </td>

                            <td>
                                <select class="profissional" name="profissional[]">
                                    <option value=""></option>
                                    <option value="{{ $voice->professional->id }}" selected>{{ $voice->professional->name }}</option>
                                </select>
                            </td>

                            <td class="group"><input type="text" name="grupo[]" value="{{ $voice->section_name }}"></td>
                            <td class="remover"><button type="button" class="remove action"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function() {
            options = populate(@json($professionals));

            let voices = @json($game->voices).length;

            if(voices == 0)
                addRow();
            else
                appendAdders();

            $(document).on('click', '.add', function() { add(this) });
            $(document).on('click', '.remove', function() { remove(this) });

            $(document).on('click', '.character', function() { focus(this) });
            $(document).on('click', '.group', function() { focus(this) });

            $(document).on('click', '#up', function() { move('up') });
            $(document).on('click', '#down', function() { move('down') });

            $('#save').on('click', function() { $('#formRole').submit(); });









            function populate(professionals) {
                let options = '';

                for (let i = 0; i < professionals.length; i++){
                    options += '<option value="'+ professionals[i].id + '">' + professionals[i].name + '</option>';
                }

                return options;
            }

            function add(target) {
                let parent = $(target).parent();

                if(parent[0].tagName == 'TR')
                    addRowAfter(parent);
                else
                    addRow();
            }

            function remove(target) {
                let parent = $(target).parent().parent();

                if(parent.parent().find('.remove').length == 1)
                    return;

                if($('#lock').is(':checked')) {
                    if(confirm('Tem certeza que deseja apagar?')) {
                        parent.remove();
                    }
                } else {
                    parent.remove();
                }
            }

            function addRow() {
                $('#roles').append(
                    '<tr id="master" class="role">' +
                        '<td><input type="radio" name="selected" class="selected"></td>' +
                        '<td class="character"><input type="text" name="personagem[]"></td>' +
                        '<td><select class="profissional" name="profissional[]"><option></option></select></td>' +
                        '<td class="group"><input type="text" name="grupo[]"></td>' +
                        '<td class="remover"><button type="button" class="remove action"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>'
                );

                $('.profissional').append(options);
                $('#roles').children().last().append($('#add').clone());
            }

            function addRowAfter(parent) {
                $(parent).after($('#master').clone().find('input:text').val('').end());
            }

            function move(direction) {
                let selected = $('input[name=selected]:checked');

                if(selected.length != 0) {
                    let parent = $(selected).parent().parent();

                    let parentSibling = '';

                    if(direction == 'up') {
                        parentSibling = $(parent).prev();

                        if(parentSibling.length != 0) {
                            parent.insertBefore(parentSibling);
                        }
                    }
                        
                    if(direction == 'down') {
                        parentSibling = $(parent).next();

                        if(parentSibling.length != 0) {
                            parent.insertAfter(parentSibling);
                        }   
                    }
                }
            }

            function focus(target) {
                $(target).children().first().focus();
            }

            function appendAdders() {
                $('.role').append($('#add').clone());
            }

            /* function adder() {
                $('#roles').find('.add').remove();

                $('#roles').children().last().append($('#add').clone());
            } */
        });
    </script>
</body>
</html>

