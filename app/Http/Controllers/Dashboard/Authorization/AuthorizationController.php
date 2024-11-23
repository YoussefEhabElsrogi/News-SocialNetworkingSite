<?php

namespace App\Http\Controllers\Dashboard\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizationRequest;
use App\Models\Authorization;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:authorizations');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authorizations = Authorization::paginate(5);
        return view('dashboard.authorizations.index', compact('authorizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.authorizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorizationRequest $request)
    {
        // return $request;
        try {
            $authorization = Authorization::create($request->only('role', 'permessions'));

            if (!$authorization) {
                setFlashMessage('error', 'Try again later.//');
                return redirect()->back()->withInput();
            }

            setFlashMessage('success', 'Role created successfully!');
        } catch (\Exception $e) {
            setFlashMessage('error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        return redirect()->route('dashboard.authorizations.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $authorization = Authorization::findOrFail($id);
        return view('dashboard.authorizations.edit', compact('authorization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the authorization by ID or fail
            $authorization = Authorization::findOrFail($id);

            // Update the authorization with the validated data
            $authorization->update($request->only('role', 'permessions'));

            // Set a success flash message
            setFlashMessage('success', 'Role Updated Successfully!');
        } catch (\Exception $e) {
            setFlashMessage('error', 'Please try again.');
            return redirect()->back()->withInput();
        }

        return redirect()->route('dashboard.authorizations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $authorization = Authorization::findOrFail($id);

        if ($authorization->admins()->exists()) {
            setFlashMessage('error', 'Please Delete Related Admin first!');
            return redirect()->back();
        }

        $authorization = $authorization->delete();

        if (!$authorization) {
            setFlashMessage('error', 'Try again latter!');
            return redirect()->back()->withInput();
        }

        return redirect()->back()->with('success', 'Role Deleted Successfully!');
    }
}
