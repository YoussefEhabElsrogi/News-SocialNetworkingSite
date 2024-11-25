<?php

namespace App\Http\Controllers\Dashboard\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:contacts');
    }
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;

        $contacts = Contact::when(request()->keyword, function ($query) {
            $query->whereAny(['name', 'title'], 'LIKE', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });

        $contacts = $contacts->orderBy($sort_by, $order_by)->paginate($limit_by);
        return view('dashboard.contacts.index', compact('contacts'));
    }
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->status != 1) {
            $contact->update(['status' => 1]);
        }
        return view('dashboard.contacts.show', compact('contact'));
    }
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact = $contact->delete();

        setFlashMessage('success', 'Conact Deleted Successfully!');
        return redirect()->route('dashboard.contacts.index');
    }
}
