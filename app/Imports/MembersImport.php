<?php

namespace App\Imports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MembersImport implements WithMultipleSheets
{
    public string $event_id;

    public function __construct(string $event_id)
    {
        $this->event_id = $event_id;
    }

    public function sheets(): array
    {
        $event = Event::with(['categories'])
            ->findOrFail($this->event_id);

        $sheets = [];

        foreach ($event->categories as $category) {
            $sheets[$category->name] = new EventMemberImport($event->id, $category->id);
        }

        return $sheets;
    }

}
