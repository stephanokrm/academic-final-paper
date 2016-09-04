@extends('app')

@section('title')
Atividades
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2">
    @if(count($activities) == 0)
    <div class="center">
        <i class="material-icons extra-large grey-text text-lighten-2">import_contacts</i>
        <h4 class="grey-text text-lighten-2">As atividades criadas pelo professor aparecem aqui</h4>
    </div>
    @else
    @if($user->isTeacher())
    {!! Form::open(['method' => 'post', 'route' => 'activities.destroy', 'class' => 'form-delete']) !!}
    @endif
    <table class="bordered highlight list-table">
        <thead>
            <tr>
                @if($user->isTeacher())
                <th width="15%">
                    <div class="center">
                        {!! Form::checkbox('select_all', null, old('select_all'), ['class' => 'filled-in', 'id' => 'select_all']) !!}
                        <label for="select_all"></label>
                    </div>
                </th>
                @endif
                <th width="35%">Atividade</th>
                <th width="38%">Data</th>
                <th width="12%" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                @if($user->isTeacher())
                <td>
                    <div class="center">
                        <input type="checkbox" name="activities[]" value="{{ $activity->getId() }}" class="filled-in checkbox-activity" id="delete_{{ $activity->getId() }}" />
                        <label for="delete_{{ $activity->getId() }}"></label>
                    </div>
                </td>
                @endif
                <td>{{ $activity->getSummary() }}</td>
                <td>{{ $activity->getDate() }}</td>
                <td>
                    <a href="{{ route('activities.edit', $activity->getId()) }}">
                        <i class="material-icons waves-effect waves-blue">mode_edit</i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('activities.show', $activity->getId()) }}">
                        <i class="material-icons waves-effect waves-blue">arrow_forward</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($user->isTeacher())
    {!! Form::close() !!}
    @endif
    @endif
</div>
@if($user->isTeacher())
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('activities.create', Input::route('id')) }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endif
@endsection

@section('js')
<script src="{{ asset('/js/activities/index.js') }}"></script>
@endsection
