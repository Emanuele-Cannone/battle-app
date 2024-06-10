<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportMembersException;
use App\Http\Requests\RegistrationRequest;
use App\Models\Event;
use App\Services\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{

    /**
     * @param RegistrationService $registrationService
     */
    public function __construct(private readonly RegistrationService $registrationService)
    {
    }

    public function landing(Event $event): View
    {


        return view('landing.event',
            [
                'event' => $event
            ]
        );
    }


    /**
     * @param RegistrationRequest $request
     * @return RedirectResponse
     * @throws ImportMembersException
     */
    public function registration(RegistrationRequest $request): RedirectResponse
    {
        $this->registrationService->register($request);

        return redirect()->route('landing', ['event' => $request->get('event_id')]);
    }
}
