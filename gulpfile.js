var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.less(['app.less'], 'public/css/app.css');

    mix.scripts([
        'app/app.module.js',
        'app/app.routes.js',
        'app/app.others.js'
    ], 'public/js/app.js');

    mix.scripts([
        'app/components/user/loginController.js',
        'app/components/user/registerController.js',
        'app/components/calendar/CalendarController.js',
        'app/components/activity/ActivityIndexController.js',
        'app/components/activity/ActivityCreateController.js',
        'app/components/activity/ActivityEditController.js',
        'app/components/activity/ActivityShowController.js',
        'app/components/activity/GradesController.js',
        'app/components/team/TeamIndexController.js',
        'app/shared/navController.js',
        'app/shared/homeController.js'
    ], 'public/js/controllers.js');

    mix.scripts([
        'app/components/user/userService.js',
        'app/components/team/teamService.js',
        'app/components/calendar/CalendarService.js',
        'app/components/google/googleService.js',
        'app/components/event/EventService.js',
        'app/components/activity/ActivityService.js'
    ], 'public/js/services.js');

    mix.scripts([], 'public/js/directives.js');
});
