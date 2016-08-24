<?php

namespace Academic\Http\Middleware;

use Closure;
use Redirect;
use Exception;
//
use Academic\Services\GoogleService;
use Academic\Exceptions\FormValidationException;
//
use Google_Auth_Exception;
use Google_Exception;
//
use Symfony\Component\HttpKernel\Exception\HttpException;

class Validation {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {
            return $next($request);
        } catch (Google_Auth_Exception $exception) {
            $service = new GoogleService();
            $service->logout();
            return Redirect::route('home')->withMessage('Sua sessão Google expirou.');
        } catch (Google_Exception $exception) {
            $service = new GoogleService();
            $message = isset($exception->getErrors()[0]['message']) ? $exception->getErrors()[0]['message'] : $exception->getMessage();
            $message = $service->translateMessage($message);
            return Redirect::back()->withMessage($message)->withInput();
        } catch (FormValidationException $exception) {
            return Redirect::back()->withErrors($exception->getErrors())->withInput();
        } catch (Exception $exception) {
            $message = $exception instanceof HttpException ? 'Funcionalidade não implementada.' : 'Ocorreu um erro inesperado.';
            return Redirect::back()->withMessage($message)->withInput();
        }
    }

}
