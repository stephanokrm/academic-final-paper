@extends('app')

@section('title')
Editar Atividade
@endsection

@section('content')
<div class="col s12 m8 offset-m4 l8 offset-l4">
    {!! Form::open(['method'  => 'patch', 'route' => ['activities.update', Input::route('id')]]) !!}
    <div class="row">
        <div class="col s12 m6 l6">
            @if(empty($calendars))
            <div class="center">
                Nenhum calendário cadastrado
                <br><br>
                <a class="waves-effect waves-light btn light-blue" href="{{ route('calendars.create') }}">Criar Calendário</a>
            </div>
            @else
            <label>Calendário</label>
            <select name="calendar_id">
                <option value="" disabled selected>Selecione</option>
                @foreach($calendars as $calendar)
                <option value="{{ $calendar->getId() }}" {{ $calendar->getId() == $activity->getCalendarId() ? 'selected' : '' }}>{{ $calendar->getSummary() }}</option>
                @endforeach
            </select>
            @if($errors->has('calendar_id'))
            <span class="help-block">{{ $errors->first('calendar_id') }}</span>
            @endif
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="summary">Título</label>
            <input id="summary" type="text" class="validate" name="summary" value="{{ $activity->getSummary() }}">
            @if($errors->has('summary'))
            <span class="help-block">{{ $errors->first('summary') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m3 l3">
            <label for="weight">Peso</label>
            <input id="weight" type="text" class="validate" name="weight" value="{{ $activity->getWeight() }}">
            @if($errors->has('weight'))
            <span class="help-block">{{ $errors->first('weight') }}</span>
            @endif
        </div>
        <div class="col s12 m3 l3">
            <label for="total_score">Nota Máxima</label>
            <input id="total_score" type="text" class="validate" name="total_score" value="{{ $activity->getTotalScore() }}">
            @if($errors->has('total_score'))
            <span class="help-block">{{ $errors->first('total_score') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m3 l3">
            <label for="date">Data</label>
            <input id="date" type="date" class="datepicker" placeholder="__/__/____" name="date" value="{{ $activity->getDate() }}">
            @if($errors->has('date'))
            <span class="help-block">{{ $errors->first('date') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="description">Descrição</label>
            <textarea length="500" id="description" name="description">{{ $activity->getDescription() }}</textarea>
            @if($errors->has('description'))
            <span class="help-block">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <label for="description">Cor da Atividade</label><br>
            @foreach ($colors->getEvent() as $id => $color)
            {!! Form::radio('color', $id, $activity->getColorId() == $id ? true : false, ['id' => 'color_' . $id, 'class' => 'square']) !!}
            <label for="color_{{ $id }}"></label>
            @endforeach
            @if($errors->has('color'))
            <br><br>
            <span class="help-block">{{ $errors->first('color') }}</span>
            @endif
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col s12 m6 l6">
            <button type="submit" class="waves-effect waves-light btn light-blue right">Concluir</button>
            <a href="{{ URL::previous() }}" class="waves-effect waves-light btn-flat light-blue-text right">Voltar</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/activities/edit.js') }}"></script>
@endsection



