<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ImportMembersException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): RedirectResponse
    {
        notyf()->error('Errori nella riga '.$this->message);
        return Redirect::route('landing', ['event' => $request->get('event_id')]);
    }
}
