@extends('app')

@section('title')
Início
@endsection

@section('content')
<div class="col s12 m12 l12">
    <div class="row center">
        <img alt="Logo Academic" class="academic-logo-home" src="{{ asset('/images/academic-logo.svg') }}">
    </div>
    <div class="row center home-page-text">
        <div class="col s12 m12 l12">
            <h2 class="white-text">Bem-vindo ao Academic</h2>
            <h5 class="white-text">Esta é a página incial.</h5>
        </div>
    </div>
</div>
@endsection
