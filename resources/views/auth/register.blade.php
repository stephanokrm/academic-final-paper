@extends('app', ['showNav' => 'true'])

@section('title')
Registro
@endsection

@section('content')

    <div class="row center">
        <div class="col s12 m12 l12">
            <img class="academic-logo-login" src="{{ asset('/images/academic-logo.svg') }}">
        </div>
    </div>
    <div class="row center">
        <div class="col s12 m12 l12">
            <h3>Bem-vindo, {{ Session::get('user')->name }}!</h3>
        </div>
        <div class="col s12 m12 l12">
            <h5>Esta é sua primeira vez no sistema, por favor preencha os campos abaixo.</h5>
        </div>
    </div>
    <br>
    {!! Form::open(['method' => 'patch', 'route' => ['users.update', Session::get('user')->id]]) !!}
    <div class="row">
        <div class="col s12 m4 offset-m4 l4 offset-l4">
            <label for="birth-date">Data de Nascimento</label>
            <input id="birth-date" type="text" placeholder="__/__/____" name="birth_date" value="{{ old('birth_date') }}">
            @if($errors->has('birth_date'))
            <span class="help-block">{{ $errors->first('birth_date') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 offset-m4 l4 offset-l4">
            <label for="email">E-mail Google</label>
            <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}">
            @if($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>
    </div>
    <div class="row center">
        <div class="col s12 m12 l12">
            <button type="submit" class="btn light-blue">Concluido</button> 
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/auth/register.js') }}"></script>
@endsection
