<?php

namespace App\Http\Controllers;

use App\Exports\MembersTemplateExport;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('admin.member.index', ['members' => Member::whereEventId($request->get('event'))->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }


    public function downloadTemplate(Request $request): BinaryFileResponse
    {
        return Excel::download(
            new MembersTemplateExport(Event::whereId($request->input('event'))->with(['categories'])->first()),
            __('registration.form.members_template').'.xlsx'
        );
    }
}
