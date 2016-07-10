<?php

// Início
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Início', route('home.index'));
});

// Início > Calendários
Breadcrumbs::register('calendars', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Calendários', route('calendars.index'));
});

// Início > Calendários > Editar
Breadcrumbs::register('calendars.edit', function($breadcrumbs) {
    $breadcrumbs->parent('calendars');
    $breadcrumbs->push('Editar', route('calendars.edit'));
});

// Início > Calendários > Eventos
Breadcrumbs::register('events.index', function($breadcrumbs) {
    $breadcrumbs->parent('calendars');
    $breadcrumbs->push('Eventos', route('events.index'));
});
