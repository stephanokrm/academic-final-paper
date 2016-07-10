@extends('app')

@section('title')
Calendários
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('calendars') !!}
@endsection

@section('content')
<div class="col s12 m6 offset-m3 l6 offset-l3">
    <div class="row first-row calendars-list">
        <ul class="collection">
            @foreach ($calendars as $calendar)
            <li class="collection-item">
                <div>
                    {{ $calendar->getSummary() }}
                    <a href="{{ route('events.index', Crypt::encrypt($calendar->getId())) }}" class="secondary-content">
                        <i class="material-icons no-margin-right">forward</i>
                    </a>
                    <a href="{{ route('calendars.edit', Crypt::encrypt($calendar->getId())) }}" class="secondary-content">
                       	<i class="material-icons">settings</i>
                    </a>
                    <a href="#!" class="secondary-content submit-calendars-delete">
                        <i class="material-icons">delete</i>
                    </a>
                    {!! Form::open([ 'method'  => 'delete', 'route' => [ 'calendars.destroy', Crypt::encrypt($calendar->getId()) ] ]) !!}
                    {!! Form::close() !!}
                </div>
            </li>
            @endforeach
        </ul>
        
    </div>
</div>
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('calendars.create') }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/calendars/index.js') }}"></script>
@endsection
