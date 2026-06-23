<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $contacts = Contact::where('company_id', $company_id)
            ->orderby('name', 'asc')
            ->get();
        return ContactResource::collection($contacts);
    }

    public function store(StoreContactRequest $request)
    {
        $request = $request->validated();
        $request['company_id'] = auth()->user()->company_id;
        $contact = Contact::create($request);
        return ContactResource::make($contact);
    }

    public function show($id)
    {
        $contact = Contact::where('company_id', auth()->user()->company_id)->findOrFail($id);
        return ContactResource::make($contact);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $request = $request->validated();
        $contact = Contact::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $contact->update($request);
        return ContactResource::make($contact);
    }

    public function destroy($id)
    {
        $contact = Contact::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $contact->delete();
        return ContactResource::make($contact);
    }
}
