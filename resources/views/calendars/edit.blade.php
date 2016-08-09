@extends('app')

@section('title')
Editar Calendário
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2">
    {!! Form::open(['method'  => 'patch', 'route' => ['calendars.update', Crypt::encrypt($calendar->getId())]]) !!}
    <div class="row">
        <div class="col s12 m6 offset-m3 l6 offset-l3">
            <label for="summary">Título</label>
            <input id="summary" type="text" class="validate" name="summary" value="{{ $calendar->getSummary() }}">
            @if($errors->has('summary'))
            <span class="help-block">{{ $errors->first('summary') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        @if(count($disassociated) > 0)
        <div class="col s12 m6 l6">
            <label>Desassociados</label>
            <table class="bordered">
                <thead>
                    <tr>
                        <th width="18%">
                            <div class="center">
                                {!! Form::checkbox('invite_all', null, old('invite_all'), ['class' => 'disassociate filled-in', 'id' => 'invite_all']) !!}
                                <label for="invite_all"></label>
                            </div>
                        </th>
                        <th>Aluno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($disassociated as $disassociate)
                    <tr>
                        <td>
                            <div class="center">
                                {!! Form::checkbox('attendees[]', $disassociate->email, old('attendees[]'), ['class' => 'disassociate invite filled-in', 'id' => 'invite_' . $disassociate->registration]) !!}
                                <label for="invite_{{ $disassociate->registration }}"></label>
                            </div>
                        </td>
                        <td>{{ $disassociate->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($errors->has('attendees'))
            <br>
            <span class="help-block">{{ $errors->first('attendees') }}</span>
            @endif
        </div>
        @else
        <div class="col s12 m6 l6">
            <div class="card-panel light-blue">
                <span class="white-text"><i class="material-icons left">error</i> Todas pessoas estão vinculadas a este calendário.
                </span>
            </div>
        </div>
        @endif
        @if(count($associated) > 0)
        <div class="col s12 m6 l6">
            <label>Associados</label>
            <table class="bordered">
                <thead>
                    <tr>
                        <th width="18%">
                            <div class="center">
                                {!! Form::checkbox('remove_all', null, old('remove_all'), ['class' => 'associate filled-in remove_all', 'id' => 'remove_all']) !!}
                                <label for="remove_all"></label>
                            </div>
                        </th>
                        <th>Aluno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($associated as $associate)
                    <tr>
                        <td>
                            <div class="center">
                                {!! Form::checkbox('disassociate[]', $associate->user->google->email, old('disassociate[]'), ['class' => 'associate remove filled-in', 'id' => 'remove_' . $associate->user->registration]) !!}
                                <label for="remove_{{ $associate->user->registration }}"></label>
                            </div>
                        </td>
                        <td>{{ $associate->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="col s12 m6 l6">
            <div class="card-panel light-blue">
                <span class="white-text"><i class="material-icons left">error</i> Nenhuma pessoa está vinculada a este calendário.
                </span>
            </div>
        </div>
        @endif
    </div>   

    <div class="row">
        <div class="col s12 m6 l6">
            <span class="help left">Somente alunos que já entraram no sistema irão aparecer aqui.</span>
        </div>
    </div>
    @if(count($disassociated) > 0)
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
        <div class="col s12 m12 l12">
            <button type="submit" class="waves-effect waves-light btn light-blue right">Concluir</button>
            <a href="{{ route('calendars.index') }}" class="waves-effect waves-light btn-flat light-blue-text right">Voltar</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/calendars/edit.js') }}"></script>
@endsection



