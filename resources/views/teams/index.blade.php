@extends('app')

@section('title')
Turmas
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2">
    @if($teams->count() == 0)
    <div class="center">
        <i class="material-icons extra-large grey-text text-lighten-2">group</i>
        <h4 class="grey-text text-lighten-2">As turmas vinculadas ao professor aparecem aqui</h4>
    </div>
    @else
    <table class="bordered highlight list-table">
        <thead>
            <tr>
                <th width="15%">Turma</th>
                <th width="15%">Curso</th>
                <th width="15%">Ano</th>
                <th width="45%">Disciplina</th>
                <th width="10%" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
            <tr>
                <td>{{ $team->year }}º Ano</td>
                <td>{{ $team->course->abbreviation }}</td>
                <td>{{ $team->school_year }}</td>
                <td>{{ $team->name }}</td>
                <td>
                    <a href="{{ route('calendars.index', $team->id) }}">
                        <i class="material-icons waves-effect waves-blue waves-circle">event_note</i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('activities.index', $team->id) }}">
                        <i class="material-icons waves-effect waves-blue waves-circle">import_contacts</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
