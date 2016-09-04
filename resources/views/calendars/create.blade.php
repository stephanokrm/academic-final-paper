@extends('app')

@section('title')
Adicionar Calendário
@endsection

@section('content')
<div class="col s12 m8 offset-m4 l8 offset-l4">
    {!! Form::open(['route' => ['calendars.store', Input::route('id')]]) !!}
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="summary">Título</label>
            <input id="summary" type="text" class="validate" name="summary" value="{{ old('summary') }}">
            @if($errors->has('summary'))
            <span class="help-block">{{ $errors->first('summary') }}</span>
            @endif
        </div>
    </div>
    @if(count($users) > 0)
    <div class="row">
        <div class="col s12 m6 l6">
            <label>Associar</label>
            <table class="bordered highlight">
                <thead>
                    <tr>
                        <th width="18%">
                            <div class="center">
                                {!! Form::checkbox('invite_all', null, old('invite_all'), ['class' => 'filled-in', 'id' => 'invite_all']) !!}
                                <label for="invite_all"></label>
                            </div>
                        </th>
                        <th>Aluno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="center">
                                {!! Form::checkbox('attendees[]', $user->google->email, old('attendees[]'), ['class' => 'invite filled-in', 'id' => 'invite_' . $user->registration]) !!}
                                <label for="invite_{{ $user->registration }}"></label>
                            </div>
                        </td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($errors->has('attendees'))
            <br>
            <span class="help-block">{{ $errors->first('attendees') }}</span>
            @endif
        </div>
    </div>   
    <div class="row">
        <div class="col s12 m6 l6">
            <span class="help left">Somente alunos que já entraram no sistema irão aparecer aqui.</span>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <label>Permissão</label>
            <p>
                {!! Form::radio('role', 'reader', old('reader'), ['id' => 'reader', 'class' => 'with-gap']) !!}
                <label for="reader">Visualizar Detalhes de Eventos</label>
            </p>
            <p>
                {!! Form::radio('role', 'writer', old('writer'), ['id' => 'writer', 'class' => 'with-gap']) !!}
                <label for="writer">Visualizar e Editar Detalhes de Eventos</label>
            </p>
            <p>
                {!! Form::radio('role', 'owner', old('owner'), ['id' => 'owner', 'class' => 'with-gap']) !!}
                <label for="owner">Editar e Compartilhar Calendário</label>
            </p>
            @if($errors->has('role'))
            <span class="help-block">{{ $errors->first('role') }}</span>
            @endif
        </div>
    </div>
    @else
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="center">
                <i class="material-icons large grey-text text-lighten-2">sentiment_dissatisfied</i>
                <h4 class="grey-text text-lighten-2">Nenhuma pessoa para ser vinculada</h4>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col s12 m6 l6">
            <button type="submit" class="waves-effect waves-light btn light-blue right"><i class="material-icons left">done</i>Concluir</button>
            <a href="{{ URL::previous() }}" class="waves-effect waves-light btn-flat light-blue-text right"><i class="material-icons left">keyboard_backspace</i>Voltar</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/calendars/create.js') }}"></script>
@endsection

