@extends('app')

@section('title')
Adicionar Evento
@endsection

@section('content')
<br><br>
<div class="row">
    <div class="col s12 m8 offset-m4 l8 offset-l4">
        {!! Form::open(['route' => 'events.store']) !!}
        <input type="hidden" name="calendar_id" value="{{ $calendar }}">
        <div class="row">
            <div class="col s12 m6 l6">
                <label for="summary">Título</label>
                <input id="summary" type="text" class="validate" name="summary" value="{{ old('summary') }}">
                @if($errors->has('summary'))
                <span class="help-block">{{ $errors->first('summary') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <p>
                    {!! Form::checkbox('all_day', 'Y', old('all_day'), ['id' => 'all_day']) !!}
                    <label for="all_day">Dia Inteiro</label>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3 l3 date_col">
                <label for="begin-date">Data de Inicio</label>
                <input id="begin-date" type="date" class="datepicker date" name="begin_date" value="{{ old('begin_date') }}">
                @if($errors->has('begin_date'))
                <span class="help-block">{{ $errors->first('begin_date') }}</span>
                @endif
            </div>
            <div class="col s12 m3 l3 hide_time">
                <label for="begin-time">Hora de Inicio</label>
                <input id="begin-time" type="text" class="validate time" name="begin_time" value="{{ old('begin_time') }}">
                @if($errors->has('begin_time'))
                <span class="help-block">{{ $errors->first('begin_time') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3 l3 date_col">
                <label for="end-date">Data de Término</label>
                <input id="end-date" type="date" class="datepicker date" name="end_date" value="{{ old('end_date') }}">
                @if($errors->has('end_date'))
                <span class="help-block">{{ $errors->first('end_date') }}</span>
                @endif
            </div>
            <div class="col s12 m3 l3 hide_time">
                <label for="end-time">Hora de Término</label>
                <input id="end-time" type="text" class="validate time" name="end_time" value="{{ old('end_time') }}">
                @if($errors->has('end_time'))
                <span class="help-block">{{ $errors->first('end_time') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <p>
                    {!! Form::checkbox('include_address', 'Y', old('include_address'), ['id' => 'include_address']) !!}
                    <label for="include_address">Incluir Endereço</label>
                </p>
            </div>
        </div>
        <div class="row hide_address hide">
            <div class="col s12 m3 l3">
                <label for="street">Rua</label>
                <input id="street" type="text" class="validate" name="street" value="{{ old('street') }}" disabled>
                @if($errors->has('street'))
                <span class="help-block">{{ $errors->first('street') }}</span>
                @endif
            </div>
            <div class="col s12 m3 l3">
                <label for="number">Número</label>
                <input id="number" type="number" class="validate" name="number" value="{{ old('number') }}" disabled>
                @if($errors->has('number'))
                <span class="help-block">{{ $errors->first('number') }}</span>
                @endif
            </div>
        </div>
        <div class="row hide_address hide">
            <div class="col s12 m3 l3">
                <label for="district">Bairro</label>
                <input id="district" type="text" class="validate" name="district" value="{{ old('district') }}" disabled>
                @if($errors->has('district'))
                <span class="help-block">{{ $errors->first('district') }}</span>
                @endif
            </div>

            <div class="col s12 m3 l3">
                <label for="city">Cidade</label>
                <input id="city" type="text" class="validate" name="city" value="{{ old('city') }}" disabled>
                @if($errors->has('city'))
                <span class="help-block">{{ $errors->first('city') }}</span>
                @endif
            </div>
        </div>
        <div class="row hide_address hide">
            <div class="col s12 m3 l3">
                <label for="state">Estado</label>
                <input id="state" type="text" class="validate" name="state" value="{{ old('state') }}" disabled>
                @if($errors->has('state'))
                <span class="help-block">{{ $errors->first('state') }}</span>
                @endif
            </div>
            <div class="col s12 m3 l3">
                <label for="country">País</label>
                <input id="country" type="text" class="validate" name="country" value="{{ old('country') }}" disabled>
                @if($errors->has('country'))
                <span class="help-block">{{ $errors->first('country') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <label for="description">Descrição</label>
                <textarea length="500" id="description" name="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                <span class="help-block">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <label for="description">Cor do Evento</label><br>
                @foreach ($colors->getEvent() as $id => $color)
                {!! Form::radio('color', $id, old('color'), ['id' => 'color_' . $id, 'class' => 'square']) !!}
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
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/events/create.js') }}"></script>
@endsection



