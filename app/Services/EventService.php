<?php

namespace App\Services;

use App\Exceptions\EventException;
use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class EventService
{
    public function create(EventRequest $request)
    {

        $validated = collect($request->validated());

        try {
            DB::beginTransaction();

            $event = Event::create($validated->toArray());

            $event->categories()->sync($validated->get('categories'));


            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error on create of event', [$e->getMessage()]);
            throw new EventException();
        }
    }
}
