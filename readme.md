<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

AngularJS [![Build Status](https://travis-ci.org/angular/angular.js.svg?branch=master)](https://travis-ci.org/angular/angular.js)
=========

AngularJS lets you write client-side web applications as if you had a smarter browser.  It lets you
use good old HTML (or HAML, Jade/Pug and friends!) as your template language and lets you extend HTML’s
syntax to express your application’s components clearly and succinctly.  It automatically
synchronizes data from your UI (view) with your JavaScript objects (model) through 2-way data
binding. To help you structure your application better and make it easy to test, AngularJS teaches
the browser how to do dependency injection and inversion of control.

It also helps with server-side communication, taming async callbacks with promises and deferreds,
and it makes client-side navigation and deeplinking with hashbang urls or HTML5 pushState a
piece of cake. Best of all? It makes development fun!

* Web site: https://angularjs.org
* Tutorial: https://docs.angularjs.org/tutorial
* API Docs: https://docs.angularjs.org/api
* Developer Guide: https://docs.angularjs.org/guide
* Contribution guidelines: [CONTRIBUTING.md](https://github.com/angular/angular.js/blob/master/CONTRIBUTING.md)
* Dashboard: https://dashboard.angularjs.org

##### Looking for the new Angular? Go here: https://github.com/angular/angular

Building AngularJS
---------
[Once you have set up your environment](https://docs.angularjs.org/misc/contribute), just run:

    grunt package


Running tests
-------------
To execute all unit tests, use:

    grunt test:unit

To execute end-to-end (e2e) tests, use:

    grunt package
    grunt test:e2e

To learn more about the grunt tasks, run `grunt --help`

Contribute & Develop
--------------------

We've set up a separate document for our [contribution guidelines](https://github.com/angular/angular.js/blob/master/CONTRIBUTING.md).


[![Analytics](https://ga-beacon.appspot.com/UA-8594346-11/angular.js/README.md?pixel)](https://github.com/igrigorik/ga-beacon)

What to use AngularJS for and when to use it
---------
AngularJS is the next generation framework where each component is designed to work with every other
component in an interconnected way like a well-oiled machine. AngularJS is JavaScript MVC made easy
and done right. (Well it is not really MVC, read on, to understand what this means.)

#### MVC, no, MV* done the right way!
MVC, short for Model-View-Controller, is a design pattern, i.e. how the code should be organized and
how the different parts of an application separated for proper readability and debugging. Model is
the data and the database. View is the user interface and what the user sees. Controller is the main
link between Model and View. These are the three pillars of major programming frameworks present on
the market today. On the other hand AngularJS works on MV*, short for Model-View-_Whatever_. The
_Whatever_ is AngularJS's way of telling that you may create any kind of linking between the Model
and the View here.

Unlike other frameworks in any programming language, where MVC, the three separate components, each
one has to be written and then connected by the programmer, AngularJS helps the programmer by asking
him/her to just create these and everything else will be taken care of by AngularJS.

#### Interconnection with HTML at the root level
AngularJS uses HTML to define the user's interface. AngularJS also enables the programmer to write
new HTML tags (AngularJS Directives) and increase the readability and understandability of the HTML
code. Directives are AngularJS’s way of bringing additional functionality to HTML. Directives
achieve this by enabling us to invent our own HTML elements. This also helps in making the code DRY
(Don't Repeat Yourself), which means once created, a new directive can be used anywhere within the
application.

HTML is also used to determine the wiring of the app. Special attributes in the HTML determine where
to load the app, which components or controllers to use for each element, etc. We specify "what"
gets loaded, but not "how". This declarative approach greatly simplifies app development in a sort
of WYSIWYG way. Rather than spending time on how the program flows and orchestrating the various
moving parts, we simply define what we want and AngularJS will take care of the dependencies.

#### Data Handling made simple
Data and Data Models in AngularJS are plain JavaScript objects and one can add and change properties
directly on it and loop over objects and arrays at will.

#### Two-way Data Binding
One of AngularJS's strongest features. Two-way Data Binding means that if something changes in the
Model, the change gets reflected in the View instantaneously, and the same happens the other way
around. This is also referred to as Reactive Programming, i.e. suppose `a = b + c` is being
programmed and after this, if the value of `b` and/or `c` is changed then the value of `a` will be
automatically updated to reflect the change. AngularJS uses its "scopes" as a glue between the Model
and View and makes these updates in one available for the other.

#### Less Written Code and Easily Maintainable Code
Everything in AngularJS is created to enable the programmer to end up writing less code that is
easily maintainable and readable by any other new person on the team. Believe it or not, one can
write a complete working two-way data binded application in less than 10 lines of code. Try and see
for yourself!

#### Testing Ready
AngularJS has Dependency Injection, i.e. it takes care of providing all the necessary dependencies
to its controllers and services whenever required. This helps in making the AngularJS code ready for
unit testing by making use of mock dependencies created and injected. This makes AngularJS more
modular and easily testable thus in turn helping a team create more robust applications.
