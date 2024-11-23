<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettignController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings');
    }
    public function index()
    {
        return view('dashboard.settings.index');
    }
    public function update(UpdateSettingRequest $request)
    {
        DB::beginTransaction();

        try {
            // Retrieve the current setting by ID
            $current_setting = Setting::findOrFail($request->setting_id);

            $data = $request->except(['_token', 'setting_id', 'logo', 'favicon']);

            // Update Logo image if provided
            $data['logo'] = $this->handleImageUpdate($request->file('logo'), $current_setting->logo, 'setting');

            // Update Favicon image if provided
            $data['favicon'] = $this->handleImageUpdate($request->file('favicon'), $current_setting->favicon, 'setting');

            // Update the current setting with the new data
            $current_setting->update($data);

            DB::commit();

            // Set a success flash message
            setFlashMessage('success', 'Setting Updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();

            // Set an error flash message
            setFlashMessage('error', 'Please try again later.');
        }

        // Redirect the user back to the settings index page
        return redirect()->route('dashboard.settings.index');
    }
    private function handleImageUpdate($newImage, $currentImagePath, $folder = 'setting')
    {
        if ($newImage) {
            ImageManager::deleteImageInLocal($currentImagePath);
            $fileName = ImageManager::generateImageName($newImage);
            return ImageManager::storeImageInLocal($newImage, $fileName, $folder);
        }
        return $currentImagePath;
    }
}
