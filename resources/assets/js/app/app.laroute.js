(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://localhost',
            routes: [{
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "\/",
                "name": null,
                "action": "Closure"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "authenticate",
                "name": "users.authenticate",
                "action": "Academic\Http\Controllers\UserController@authenticate"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "logout",
                "name": "users.logout",
                "action": "Academic\Http\Controllers\UserController@logout"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "create-auth-url",
                "name": "googles.createAuthUrl",
                "action": "Academic\Http\Controllers\GoogleController@createAuthUrl"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "google-authenticate",
                "name": "googles.authenticate",
                "action": "Academic\Http\Controllers\GoogleController@authenticate"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "google-logout",
                "name": "googles.logout",
                "action": "Academic\Http\Controllers\GoogleController@logout"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "users-by-team",
                "name": "users.byTeam",
                "action": "Academic\Http\Controllers\UserController@usersByTeam"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "calendars\/{id}\/attendees",
                "name": "calendars.attendees",
                "action": "Academic\Http\Controllers\CalendarController@attendees"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "calendars\/{id}\/not-attendees",
                "name": "calendars.notAttendees",
                "action": "Academic\Http\Controllers\CalendarController@notAttendees"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "calendars\/add-attendee",
                "name": "calendars.addAttendee",
                "action": "Academic\Http\Controllers\CalendarController@addAttendee"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "calendars\/remove-attendee",
                "name": "calendars.removeAttendee",
                "action": "Academic\Http\Controllers\CalendarController@removeAttendee"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "all-events",
                "name": "events.index",
                "action": "Academic\Http\Controllers\EventController@index"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "events\/{id}\/destroy",
                "name": "events.destroy",
                "action": "Academic\Http\Controllers\EventController@destroy"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "atividades\/{id}\/detalhes-aluno",
                "name": "activities.details",
                "action": "Academic\Http\Controllers\ActivityController@details"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "turma\/{team}\/atividades",
                "name": "activities.index",
                "action": "Academic\Http\Controllers\ActivityController@index"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "aluno\/atividades",
                "name": "activities.fromStudent",
                "action": "Academic\Http\Controllers\ActivityController@fromStudent"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "users",
                "name": "users.index",
                "action": "Academic\Http\Controllers\UserController@index"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "users\/create",
                "name": "users.create",
                "action": "Academic\Http\Controllers\UserController@create"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "users",
                "name": "users.store",
                "action": "Academic\Http\Controllers\UserController@store"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "users\/{users}",
                "name": "users.show",
                "action": "Academic\Http\Controllers\UserController@show"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "users\/{users}\/edit",
                "name": "users.edit",
                "action": "Academic\Http\Controllers\UserController@edit"
            }, {
                "host": null,
                "methods": ["PUT"],
                "uri": "users\/{users}",
                "name": "users.update",
                "action": "Academic\Http\Controllers\UserController@update"
            }, {
                "host": null,
                "methods": ["PATCH"],
                "uri": "users\/{users}",
                "name": null,
                "action": "Academic\Http\Controllers\UserController@update"
            }, {
                "host": null,
                "methods": ["DELETE"],
                "uri": "users\/{users}",
                "name": "users.destroy",
                "action": "Academic\Http\Controllers\UserController@destroy"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "teams",
                "name": "teams.index",
                "action": "Academic\Http\Controllers\TeamController@index"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "teams\/create",
                "name": "teams.create",
                "action": "Academic\Http\Controllers\TeamController@create"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "teams",
                "name": "teams.store",
                "action": "Academic\Http\Controllers\TeamController@store"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "teams\/{teams}",
                "name": "teams.show",
                "action": "Academic\Http\Controllers\TeamController@show"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "teams\/{teams}\/edit",
                "name": "teams.edit",
                "action": "Academic\Http\Controllers\TeamController@edit"
            }, {
                "host": null,
                "methods": ["PUT"],
                "uri": "teams\/{teams}",
                "name": "teams.update",
                "action": "Academic\Http\Controllers\TeamController@update"
            }, {
                "host": null,
                "methods": ["PATCH"],
                "uri": "teams\/{teams}",
                "name": null,
                "action": "Academic\Http\Controllers\TeamController@update"
            }, {
                "host": null,
                "methods": ["DELETE"],
                "uri": "teams\/{teams}",
                "name": "teams.destroy",
                "action": "Academic\Http\Controllers\TeamController@destroy"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "calendars",
                "name": "calendars.index",
                "action": "Academic\Http\Controllers\CalendarController@index"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "calendars\/create",
                "name": "calendars.create",
                "action": "Academic\Http\Controllers\CalendarController@create"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "calendars",
                "name": "calendars.store",
                "action": "Academic\Http\Controllers\CalendarController@store"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "calendars\/{calendars}",
                "name": "calendars.show",
                "action": "Academic\Http\Controllers\CalendarController@show"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "calendars\/{calendars}\/edit",
                "name": "calendars.edit",
                "action": "Academic\Http\Controllers\CalendarController@edit"
            }, {
                "host": null,
                "methods": ["PUT"],
                "uri": "calendars\/{calendars}",
                "name": "calendars.update",
                "action": "Academic\Http\Controllers\CalendarController@update"
            }, {
                "host": null,
                "methods": ["PATCH"],
                "uri": "calendars\/{calendars}",
                "name": null,
                "action": "Academic\Http\Controllers\CalendarController@update"
            }, {
                "host": null,
                "methods": ["DELETE"],
                "uri": "calendars\/{calendars}",
                "name": "calendars.destroy",
                "action": "Academic\Http\Controllers\CalendarController@destroy"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "activities\/create",
                "name": "activities.create",
                "action": "Academic\Http\Controllers\ActivityController@create"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "activities",
                "name": "activities.store",
                "action": "Academic\Http\Controllers\ActivityController@store"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "activities\/{activities}",
                "name": "activities.show",
                "action": "Academic\Http\Controllers\ActivityController@show"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "activities\/{activities}\/edit",
                "name": "activities.edit",
                "action": "Academic\Http\Controllers\ActivityController@edit"
            }, {
                "host": null,
                "methods": ["PUT"],
                "uri": "activities\/{activities}",
                "name": "activities.update",
                "action": "Academic\Http\Controllers\ActivityController@update"
            }, {
                "host": null,
                "methods": ["PATCH"],
                "uri": "activities\/{activities}",
                "name": null,
                "action": "Academic\Http\Controllers\ActivityController@update"
            }, {
                "host": null,
                "methods": ["DELETE"],
                "uri": "activities\/{activities}",
                "name": "activities.destroy",
                "action": "Academic\Http\Controllers\ActivityController@destroy"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "colors",
                "name": "colors.index",
                "action": "Academic\Http\Controllers\ColorController@index"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "colors\/create",
                "name": "colors.create",
                "action": "Academic\Http\Controllers\ColorController@create"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "colors",
                "name": "colors.store",
                "action": "Academic\Http\Controllers\ColorController@store"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "colors\/{colors}",
                "name": "colors.show",
                "action": "Academic\Http\Controllers\ColorController@show"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "colors\/{colors}\/edit",
                "name": "colors.edit",
                "action": "Academic\Http\Controllers\ColorController@edit"
            }, {
                "host": null,
                "methods": ["PUT"],
                "uri": "colors\/{colors}",
                "name": "colors.update",
                "action": "Academic\Http\Controllers\ColorController@update"
            }, {
                "host": null,
                "methods": ["PATCH"],
                "uri": "colors\/{colors}",
                "name": null,
                "action": "Academic\Http\Controllers\ColorController@update"
            }, {
                "host": null,
                "methods": ["DELETE"],
                "uri": "colors\/{colors}",
                "name": "colors.destroy",
                "action": "Academic\Http\Controllers\ColorController@destroy"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "events\/create",
                "name": "events.create",
                "action": "Academic\Http\Controllers\EventController@create"
            }, {
                "host": null,
                "methods": ["POST"],
                "uri": "events",
                "name": "events.store",
                "action": "Academic\Http\Controllers\EventController@store"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "events\/{events}",
                "name": "events.show",
                "action": "Academic\Http\Controllers\EventController@show"
            }, {
                "host": null,
                "methods": ["GET", "HEAD"],
                "uri": "events\/{events}\/edit",
                "name": "events.edit",
                "action": "Academic\Http\Controllers\EventController@edit"
            }, {
                "host": null,
                "methods": ["PUT"],
                "uri": "events\/{events}",
                "name": "events.update",
                "action": "Academic\Http\Controllers\EventController@update"
            }, {
                "host": null,
                "methods": ["PATCH"],
                "uri": "events\/{events}",
                "name": null,
                "action": "Academic\Http\Controllers\EventController@update"
            }],
            prefix: '',

            route: function (name, parameters, route) {
                route = route || this.getByName(name);

                if (!route) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute: function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters: function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function (match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString: function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName: function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction: function (action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if (!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function (attributes) {
            if (!attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action: function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route: function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url: function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to: function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route: function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action: function (action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports) {
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

