<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\RelatedNewsSite;
use Illuminate\Http\Request;

class RelatedSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = RelatedNewsSite::latest()->paginate(8);
        return view('dashboard.relatedsites.index', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate(RelatedNewsSite::filterRequest());

        // Create the site
        $site = RelatedNewsSite::create($request->only(['name', 'url']));

        if (!$site) {
            // Flash error message if the site was not created
            setFlashMessage('error', 'Site Not Created');
            return redirect()->back();
        }

        // Flash success message and redirect back
        setFlashMessage('success', 'Site Created Successfully');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $request->validate(RelatedNewsSite::filterRequest());

        // Find the site by ID
        $site = RelatedNewsSite::find($id);

        // If the site does not exist, redirect back with error message
        if (!$site) {
            setFlashMessage('error', 'Site Not Found');
            return redirect()->back();
        }

        // Update the site
        $site->update($request->only(['name', 'url']));

        // Flash success message and redirect back
        setFlashMessage('success', 'Site Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the site by ID
        $site = RelatedNewsSite::find($id);

        // If the site does not exist, redirect back with error message
        if (!$site) {
            setFlashMessage('error', 'Site Not Found');
            return redirect()->back();
        }

        // Delete the site
        $site->delete();

        // Flash success message and redirect back
        setFlashMessage('success', 'Site Deleted Successfully');
        return redirect()->back();
    }
}
