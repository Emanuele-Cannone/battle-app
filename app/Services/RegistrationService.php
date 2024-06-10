<?php

namespace App\Services;

use App\Exceptions\ImportMembersException;
use App\Http\Requests\RegistrationRequest;
use App\Imports\MembersImport;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

readonly class RegistrationService
{

    /**
     * @param RegistrationRequest $request
     * @return void
     * @throws ImportMembersException
     */
    public function register(RegistrationRequest $request): void
    {
        $validated = collect($request->validated());

        try {
            DB::beginTransaction();

            if($request->has('member_file')){
                Excel::import(new MembersImport($validated->get('event_id')), $request->file('member_file'));
            } else {
                Member::create($validated->toArray());
            }

            notyf()->success('Iscrizione Effettuata con successo');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error on registration', [$e->getMessage()]);

            if($e instanceof \Maatwebsite\Excel\Validators\ValidationException){
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    throw new ImportMembersException($failure->row());
                }

            }

            throw new ImportMembersException($e->getMessage());
        }
    }
}
