@extends('app')

@section('title')
Adicionar Calendário
@endsection

@section('content')
<br><br>
<div class="row">
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
                <table class="bordered">
                    <thead>
                        <tr>
                            <th data-field="id">Aluno</th>
                            <th data-field="name">Convidar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Todos</td>
                            <td>
                                <p>
                                    {!! Form::checkbox('invite_all', null, old('invite_all'), ['id' => 'invite_all']) !!}
                                    <label for="invite_all"></label>
                                </p>
                            </td>
                        </tr>
                        @foreach($students as $student)
                        @if(isset($student->googleEmail->email))
                        <tr>
                            <td>{{ ucwords($student->nome_completo) }}</td>
                            <td>
                                <p>
                                    {!! Form::checkbox('attendees[]', $student->googleEmail->email, old('attendees[]'), ['class' => 'invite', 'id' => 'invite_' . $student->matricula]) !!}
                                    <label for="invite_{{ $student->matricula }}"></label>
                                </p>
                            </td>
                        </tr>
                        @endif
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
        @endif

        <div class="row">
            <div class="col s12 m6 l6">
                <button type="submit" class="waves-effect waves-light btn light-blue right">Concluir</button>
                <a href="{{ route('calendars.index') }}" class="waves-effect waves-light btn-flat light-blue-text right">Voltar</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('/js/calendar/create.js') }}"></script>
@endsection

