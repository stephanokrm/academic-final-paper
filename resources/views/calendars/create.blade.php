@extends('app')

@section('title')
Adicionar Calendário
@endsection

@section('content')
<div class="col s12 m8 offset-m4 l8 offset-l4">
    {!! Form::open(['route' => 'calendars.store']) !!}
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="summary">Título</label>
            <input id="summary" type="text" class="validate" name="summary" value="{{ old('summary') }}">
            @if($errors->has('summary'))
            <span class="help-block">{{ $errors->first('summary') }}</span>
            @endif
        </div>
    </div>
    @if(count($students) > 0)
    <div class="row">
        <div class="col s12 m6 l6">
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
                    @foreach($students as $student)
                    <tr>
                        <td>
                            <div class="center">
                                {!! Form::checkbox('attendees[]', $student->user->google->email, old('attendees[]'), ['class' => 'invite filled-in', 'id' => 'invite_' . $student->user->registration]) !!}
                                <label for="invite_{{ $student->user->registration }}"></label>
                            </div>
                        </td>
                        <td>{{ ucwords($student->user->name) }}</td>
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
                {!! Form::radio('role', 'reader', old('reader'), ['id' => 'reader']) !!}
                <label for="reader">Visualizar Detalhes de Eventos</label>
            </p>
            <p>
                {!! Form::radio('role', 'writer', old('writer'), ['id' => 'writer']) !!}
                <label for="writer">Visualizar e Editar Detalhes de Eventos</label>
            </p>
            <p>
                {!! Form::radio('role', 'owner', old('owner'), ['id' => 'owner']) !!}
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
            <div class="card-panel light-blue">
                <span class="white-text"><i class="material-icons left">error</i> Nenhuma pessoa para ser vinculada.
                </span>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col s12 m6 l6">
            <button type="submit" class="waves-effect waves-light btn light-blue right">Concluir</button>
            <a href="{{ route('calendars.index') }}" class="waves-effect waves-light btn-flat light-blue-text right">Voltar</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/calendars/create.js') }}"></script>
@endsection

