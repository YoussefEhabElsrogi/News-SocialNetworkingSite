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
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'unique:new_subscribers,email']
        ]);

        $newSubscriber = NewSubscriber::create($data);

        if (!$newSubscriber) {
            Session::flash('error', 'Sorry Try Again Letter');
            return redirect()->back();
        }

        Mail::to($data)->send(new NewSubscriberMail());

        Session::flash('success', 'Thanks For Subscribe');
        return redirect()->back();
    }
}
