<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreContactRequest;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    use ApiResponseTrait;

    public function storeContact(StoreContactRequest $request)
    {
        // Validate and get the request data
        $validatedData = $request->validated();

        // Add the IP address to the validated data
        $validatedData['ip_address'] = $request->ip();

        // Create the contact
        $contact = Contact::create(Arr::only($validatedData, ['name', 'email', 'title', 'body', 'phone', 'ip_address']));

        // Send notification to admins
        $admins = Admin::all();
        Notification::send($admins, new NewContactNotify($contact));

        // Return a success response
        return $this->sendResponse(200, 'Contact Created Successfully', null);
    }
}
