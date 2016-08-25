@extends('app')

@section('title')
Calendários
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2">
    @if(empty($calendars))
    <div class="center">
        <i class="material-icons extra-large grey-text text-lighten-2">event_note</i>
        <h4 class="grey-text text-lighten-2">Os calendários criados no Academic aparecem aqui</h4>
    </div>
    @else
    {!! Form::open([ 'method'  => 'post', 'route' => 'calendars.destroy', 'class' => 'form-delete']) !!}
    <table class="bordered highlight list-table">
        <thead>
            <tr>
                <th width="15%">
                    <div class="center">
                        {!! Form::checkbox(null, null, null, ['class' => 'filled-in', 'id' => 'select_all']) !!}
                        <label for="select_all"></label>
                    </div>
                </th>
                <th width="73%">Calendário</th>
                <th width="12%" colspan="3">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($calendars as $calendar)
            <tr>
                <td>
                    <div class="center">
                        <input type="checkbox" name="calendars[]" value="{{ $calendar->getId() }}" class="filled-in checkbox-calendar" id="delete_{{ $calendar->getId() }}" />
                        <label for="delete_{{ $calendar->getId() }}"></label>
                    </div>
                </td>
                <td>{{ $calendar->getSummary() }}</td>
                <td>
                    <a href="{{ route('calendars.edit', Crypt::encrypt($calendar->getId())) }}">
                        <i class="material-icons waves-effect waves-blue">mode_edit</i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('events.index', Crypt::encrypt($calendar->getId())) }}">
                        <i class="material-icons waves-effect waves-blue">arrow_forward</i>
                    </a>
                </td>
                <td>
                    <a href="#">
                        <i class="material-icons waves-effect waves-blue">more_vert</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::close() !!} 
    @endif
</div>
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('calendars.create', Input::route('id')) }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/calendars/index.js') }}"></script>
@endsection
