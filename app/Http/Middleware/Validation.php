<?php

namespace Academic\Http\Middleware;

use Closure;
use Redirect;
use Exception;
//
use Academic\Services\GoogleService;
use Academic\Exceptions\FormValidationException;
//
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
        } catch (Google_Exception $exception) {
            $service = new GoogleService();
            $message = isset($exception->getErrors()[0]['message']) ? $exception->getErrors()[0]['message'] : $exception->getMessage();
            $messageInPortuguese = $service->translateMessage($message);
            return $request->ajax() ? response()->json(['error' => $messageInPortuguese]) : Redirect::back()->withMessage($messageInPortuguese)->withInput();
        } catch (FormValidationException $exception) {
            return $request->ajax() ? response()->json(['error' => $exception->getErrors()]) : Redirect::back()->withErrors($exception->getErrors())->withInput();
        } catch (Exception $exception) {
            return response()->json($exception->getMessage());
            $message = $exception instanceof HttpException ? 'Funcionalidade não implementada.' : 'Ocorreu um erro inesperado.';
            return $request->ajax() ? response()->json(['error' => $message]) : Redirect::back()->withMessage($message)->withInput();
        }
    }

}
