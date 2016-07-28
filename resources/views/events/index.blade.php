@extends('app')

@section('title')
Eventos
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('events.index') !!}
@endsection

@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('/fullcalendar/fullcalendar.min.css') }}" media="screen,projection"/>
@endsection

@section('content')
@if(count($events) > 0)
<div id="event" class="modal">
    <div class="modal-header center">
        <h4 class="truncate"></h4>
    </div> 
    <div class="modal-content"> 
        <div class="row">
            <div class="col s12 m12 l12 left description">
                <h5><i class="material-icons left medium">description</i> Descrição</h5>
                <p></p>
            </div>
        </div> 
        <hr>
        <div class="row">
            <br>
            <div class="col s12 m12 l12 left event-date">
                <h5><i class="material-icons left medium">alarm</i> Data</h5>
                <p></p>
            </div>
        </div> 
    </div> 
    <hr>
    <div class="modal-footer event-modal-footer"> 
        <a href="#!" class="modal-action modal-close waves-effect btn-flat close-event-btn">Fechar</a>
        <a href="" class="edit-button-event waves-effect btn-flat">Editar</a>
        <form method="POST" action="" accept-charset="UTF-8">
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="calendar_id" type="hidden" value="{{ $calendar }}">
            <button type="submit" class="btn-flat waves-effect">Excluir</button>
        </form>
    </div> 
</div>
<div class="row first-row-events events-list">
    <div class="col s12 m3 l2" id="events-colletion">
        <ul class="collection with-header">
            <li class="collection-header white-text center">Próximos Eventos</li>
            @foreach($events as $event)
            <li class="collection-item" data-idcalendar="{{ Input::route('id') }}" data-id="{{ $event->getId() }}" data-color="{{ $event->getColorId() }}" data-summary="{{ $event->getSummary() }}" data-start="{{ $event->getOriginalBeginDate() }}" data-end="{{ $event->getOriginalEndDate() }}">
                @if($event->hasDescription())
                <div class="data-description" data-description="{{ $event->getDescription() }}"></div>
                @endif
                <div class="data-dateformated" data-dateformated="{{ $event->getBeginDate() . $event->getBeginTime() }} até {{ $event->getEndDate() . $event->getEndTime() }}"></div>
                <div>
                    {{ $event->getSummary() }}
                </div>
            </li>
            @endforeach
        </ul>

    </div>
    <div class="col s12 m9 l10" id="events-calendar">
        <div class="row">
            <div id="calendar"></div>
        </div>
    </div>
</div>
@else
<div class="row first-row">
    <div class="center">
        <i class="material-icons extra-large grey-text text-lighten-2">event</i>
        <h4 class="grey-text text-lighten-2">Os eventos criados aparecem aqui.</h4>
    </div>
</div>
@endif
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('events.create', Input::route('id')) }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/laroute.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/lib/moment.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/fullcalendar.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/lang-all.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/gcal.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/events/index.js') }}"></script>
@endsection
