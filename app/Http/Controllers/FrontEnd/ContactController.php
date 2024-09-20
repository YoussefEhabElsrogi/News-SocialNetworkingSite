<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreContactRequest;
use App\Models\Contact;

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

        setFlashMessage('success', 'Your Message Created Successfully');
        return redirect()->back();

        // try {
        //     return redirect()->route('front.contact.create')->with('success', 'Contact information saved successfully!');
        // } catch (\Exception $e) {
        //     setFlashMessage('error', 'Contact Us Faild');
        // }
    }
}
