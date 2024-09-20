<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriberMail;
use App\Models\NewSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewSubscriberController extends Controller
{
    /**
     * Handle the incoming request to store a new subscriber.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'email' => ['required', 'email', 'unique:new_subscribers,email']
        ]);

        // Create a new subscriber record
        $newSubscriber = NewSubscriber::create($data);

        // Check if the subscriber was created successfully
        if (!$newSubscriber) {
            // Set an error flash message if creation failed
            setFlashMessage('error', 'Sorry, something went wrong. Please try again.');
            return redirect()->back();
        }

        // Send a subscription confirmation email to the new subscriber
        Mail::to($data['email'])->send(new NewSubscriberMail());

        // Set a success flash message
        setFlashMessage('success', 'Thanks for subscribing!');

        // Redirect back to the previous page
        return redirect()->back();
    }
}
