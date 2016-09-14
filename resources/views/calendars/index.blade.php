@extends('app')

@section('title')
Calendários
@endsection

@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('/bower_components/fullcalendar/dist/fullcalendar.min.css') }}" media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="{{ asset('/css/calendars/index.css') }}"/>
@endsection

@section('content')
<div id="event" class="modal">
    <div class="modal-header">
        <div class="row">
            <div class="col s10 m10 l10 event-title">
                <div class="event-title-text truncate"></div>
            </div>
            <div class="col s2 m2 l2 event-edit">
                <a class="btn-floating btn-large waves-effect waves-light red right modal-trigger" id="event_edit" href="#event-create"><i class="material-icons">mode_edit</i></a>
            </div>
        </div>  
    </div>
    <div class="modal-content"> 
        <div class="row row-content">
            <div class="col s2 m1 l1">
                <i class="material-icons small grey-text text-darken-1">access_time</i>
            </div>
            <div class="col s10 m11 l11 event-date"></div>
        </div> 
        <div class="row">
            <div class="col s2 m1 l1">
                <i class="material-icons small grey-text text-darken-1">description</i>
            </div>
            <div class="col s10 m11 l11 description"></div>
        </div>
    </div>
</div>
<div id="calendar-modal" class="modal">
    <div class="modal-header light-blue darken-1">
        <div class="row">
            <div class="col s6 m8 l8 calendar-title">
                <div class="calendar-title-text truncate white-text"></div>
            </div>
            <div class="col s3 m2 l2 event-edit">
                <form method="POST" action="" accept-charset="UTF-8" id="delete-calendar-form">
                    <input name="_method" type="hidden" value="DELETE">
                    {!! Form::token() !!}
                    <button type="submit" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">delete</i></button>
                </form>
            </div>
            <div class="col s3 m2 l2 event-edit">
                <a class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">mode_edit</i></a>
            </div>
        </div>  
    </div>
    <div class="modal-content"><br></div>
</div>
<div class="row" id="calendar-panel">
    <div class="col s12 m4 l4">
        <a class="waves-effect waves-light btn light-blue" href="{{ route('calendars.create') }}">Adicionar Calendário</a>
    </div>
    <div class="col s12 m4 l4">
        <div class="row">
            <div class="col s1 m1 l1 offset-s1 offset-m3 offset-l3">
                <i id="left_arrow" class="material-icons white-text waves-effect waves-circle waves-light left">keyboard_arrow_left</i>
            </div>
            <div class="col s6 m5 l5 offset-s1 center">
                <h5 class="white-text" id="calendar_date"></h5>
            </div>
            <div class="col s1 m1 l1 offset-s1">
                <i id="right_arrow" class="material-icons white-text waves-effect waves-circle waves-light left">keyboard_arrow_right</i>
            </div>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <div class="row">
            <div class="col s2 m2 l1 offset-s2 offset-m2 offset-l6">
                <i id="today" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Hoje">today</i>
            </div>
            <div class="col s2 m2 l1">
                <i id="day_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Dia">view_day</i>
            </div>
            <div class="col s2 m2 l1">
                <i id="week_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Semana">view_column</i>
            </div>
            <div class="col s2 m2 l1">
                <i id="month_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light" data-position="bottom" data-delay="50" data-tooltip="Mês">view_module</i>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="event-create" class="modal modal-fixed-footer">
    {!! Form::open(['id' => 'event_crete_form']) !!}
    <div class="modal-content">
        <div class="row valign-wrapper">
            <div class="input-field col s10 m10 l10">
                <h4>Adicionar Evento</h4>
            </div>
            <div class="col s2 m2 l2 valign">
                <a class="modal-action modal-close waves-effect waves-light waves-circle right"><i class="material-icons">clear</i></a>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <select name="calendar_id" id="calendar_select">
                    <option value="" disabled selected>Selecione o calendário</option>
                    @foreach($calendars as $calendar)
                    <option value="{{ $calendar->getId() }}">{{ $calendar->getSummary() }}</option>
                    @endforeach
                </select>
                <label>Calendário</label>
                @if($errors->has('calendar_id'))
                <span class="help-block">{{ $errors->first('calendar_id') }}</span>
                @endif
            </div>
        </div>
        <div class="row valign-wrapper">
            <div class="input-field col s12 m9 l9">
                <input id="summary" type="text" class="validate black-text" name="summary" value="{{ old('summary') }}">
                <label for="summary">Título</label>
                @if($errors->has('summary'))
                <span class="help-block">{{ $errors->first('summary') }}</span>
                @endif
            </div>
            <div class="col s12 m3 l3 valign">
                <div class="switch ">
                    <label>
                        {!! Form::checkbox('all_day', 'Y', old('all_day'), ['id' => 'all_day']) !!}
                        <span class="lever"></span>
                        Dia inteiro
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input id="begin-date" type="text" class="validate black-text date" name="begin_date" value="{{ old('begin_date') }}">
                <label for="begin-date">Data de Inicio</label>
                @if($errors->has('begin_date'))
                <span class="help-block">{{ $errors->first('begin_date') }}</span>
                @endif
            </div>
            <div class="input-field col s12 m6 l6">
                <input id="begin-time" type="text" class="validate black-text time" name="begin_time" value="{{ old('begin_time') }}">
                <label for="begin-time">Hora de Inicio</label>
                @if($errors->has('begin_time'))
                <span class="help-block">{{ $errors->first('begin_time') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input id="end-date" type="text" class="validate black-text date" name="end_date" value="{{ old('end_date') }}">
                <label for="end-date">Data de Término</label>
                @if($errors->has('end_date'))
                <span class="help-block">{{ $errors->first('end_date') }}</span>
                @endif
            </div>
            <div class="input-field col s12 m6 l6">
                <input id="end-time" type="text" class="validate time" name="end_time" value="{{ old('end_time') }}">
                <label for="end-time">Hora de Término</label>
                @if($errors->has('end_time'))
                <span class="help-block">{{ $errors->first('end_time') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <textarea length="500" id="description" name="description" class="validate materialize-textarea">{{ old('description') }}</textarea>
                <label for="description">Descrição</label>
                @if($errors->has('description'))
                <span class="help-block">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <select class="select-colors validate" name="color" id="colors_select">
                    <option value="" disabled selected>Selecione a cor</option>
                    @foreach ($colors->getEvent() as $id => $color)
                    <option value="{{ $id }}">{{ $color_helper->getColorName($id) }}</option>
                    @endforeach
                </select>
                <label>Cor</label>
                @if($errors->has('color'))
                <span class="help-block">{{ $errors->first('color') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row valign-wrapper">
            <div class="col s6 m6 l6 valign">
                <a><i class="material-icons modal-action modal-close waves-effect waves-light waves-circle">delete</i></a> 
            </div>
            <div class="col s6 m6 l6">
                <button type="submit" class="btn btn-flat modal-action waves-effect waves-light" id="submit_event"><i class="material-icons left">done</i>Salvar</button> 
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="row">
    <div class="col s12 m4 l2">
        <ul class="collapsible calendar-collection" data-collapsible="accordion">
            <li>
                <div class="collapsible-header active" id="calendars-collapsible-header">Calendários<i class="material-icons right" id="keyboard_arrow_up">keyboard_arrow_up</i><i class="material-icons right hide" id="keyboard_arrow_down">keyboard_arrow_down</i></div>
                <div class="collapsible-body">
                    <ul class="collection calendar-collection">
                        @foreach($calendars as $calendar)
                        <li class="collection-item">
                            <div class="row">
                                <div class="col s9 m9 l8 truncate">
                                    {{ $calendar->getSummary() }}
                                </div>
                                <div class="col s2 m2 l2">
                                    <input type="checkbox" class="filled-in" data-id="{{ $calendar->getId() }}" id="calendar_{{ $calendar->getId() }}" checked="checked" />
                                    <label for="calendar_{{ $calendar->getId() }}"></label>
                                </div>
                                <div class="col s1 m1 l2">
                                    <i data-constrainwidth="false" data-activates='dropdown_{{ $calendar->getSummary() }}' class="dropdown-button material-icons black-text right more-options-calendar" data-id="{{ Crypt::encrypt($calendar->getId()) }}" data-summary="{{ $calendar->getSummary() }}">more_vert</i>
                                </div>
                            </div>
                            <ul id="dropdown_{{ $calendar->getSummary() }}" class="dropdown-content custom-dropdown-content">
                                <li><a>Editar</a></li>
                                {!! Form::open(['route' => ['calendars.destroy', Crypt::encrypt($calendar->getId())], 'method' => 'delete']) !!}
                                <li><a class="remove-calendar">Remover</a></li>
                                {!! Form::close() !!}
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="col s12 m8 l10">
        <div id="calendar"></div>
    </div>
</div>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red modal-trigger waves-effect waves-light" href="#event-create">
        <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/laroute.js') }}"></script>
<script type='text/javascript' src="{{ asset('/bower_components/moment/min/moment.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/bower_components/fullcalendar/dist/locale/pt-br.js') }}"></script>
<script type='text/javascript' src="{{ asset('/bower_components/fullcalendar/dist/gcal.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/calendars/index.js') }}"></script>
@endsection
