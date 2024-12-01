<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreContactRequest;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function create()
    {
        return view('frontend.contact-us');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        $data['ip_address'] = $request->ip();

        $contact = Contact::create($data);

        if (!$contact) {
            setFlashMessage('error', 'Contact Us Faild');
            return redirect()->back();
        }

        $admins = Admin::get();

        Notification::send($admins, new NewContactNotify($contact));

        setFlashMessage('success', 'Your Message Created Successfully');
        return redirect()->back();
    }
}
