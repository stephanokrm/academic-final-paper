<?php

// Início
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Início', route('home.index'));
});

// Início > Calendários
Breadcrumbs::register('calendars', function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Calendários', route('calendars.index'));
});