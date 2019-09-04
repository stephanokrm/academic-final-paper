const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/app.js', 'public/js/bootstrap.js');

mix.sass('resources/sass/app.scss', 'public/css').scripts([
    'resources/js/app/app.module.js',
    'resources/js/app/app.routes.js',
    'resources/js/app/app.others.js',
    'resources/js/app/app.laroute.js'
], 'public/js/app.js').scripts([
    'resources/js/app/components/user/LoginController.js',
    'resources/js/app/components/user/RegisterController.js',
    'resources/js/app/components/calendar/CalendarController.js',
    'resources/js/app/components/activity/ActivityIndexController.js',
    'resources/js/app/components/activity/ActivityCreateController.js',
    'resources/js/app/components/activity/ActivityEditController.js',
    'resources/js/app/components/activity/ActivityShowController.js',
    'resources/js/app/components/activity/GradesController.js',
    'resources/js/app/components/team/TeamIndexController.js',
    'resources/js/app/shared/NavigationController.js',
    'resources/js/app/shared/HomeController.js'
], 'public/js/controllers.js').scripts([
    'resources/js/app/components/user/UserService.js',
    'resources/js/app/components/team/TeamService.js',
    'resources/js/app/components/calendar/CalendarService.js',
    'resources/js/app/components/google/GoogleService.js',
    'resources/js/app/components/event/EventService.js',
    'resources/js/app/components/activity/ActivityService.js'
], 'public/js/services.js');
