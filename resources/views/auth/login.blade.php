@extends('app', ['showNav' => 'true'])

@section('title')
Login
@endsection

@section('content')
<div class="col s12 m4 offset-m4 l4 offset-l4">
    <div class="row center">
        <div class="col s12 m12 l12">
            <img class="academic-logo-login" src="{{ asset('/images/academic-logo.svg') }}">
        </div>
    </div>
    <div class="row center">
        <div class="col s12 m12 l12">
            <h2>Academic</h2>
        </div>
    </div>
    {!! Form::open(['method' => 'POST', 'route' => 'auth.ldap']) !!}
    <div class="row">
        <div class="col s12 m12 l12">
            {!! Form::label('username', 'Matrícula') !!}
            {!! Form::text('username', null) !!}
            @if($errors->has('username'))
            <span class="help-block">{{ $errors->first('username') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            {!! Form::label('password', 'Senha') !!}
            {!! Form::password('password') !!}
            @if($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
            @endif
        </div>
    </div>
    <div class="row center">
        <div class="col s12 m12 l12">
            <button type="submit" class="btn light-blue">Entrar</button> 
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection
