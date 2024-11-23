<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order_by = $request->order_by ?? 'desc';
        $sort_by = $request->sort_by ?? 'id';
        $limit_by = $request->limit_by ?? 5;

        $users = User::when($request->keyword, function ($query) use ($request) {
            $query->whereAny(['name', 'email'], 'LIKE', '%' . $request->keyword . '%');
        })
            ->when(!is_null($request->status), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Get validated data
        $validatedData = $this->prepareValidatedData($request->validated());

        try {
            DB::beginTransaction();

            // Create the user
            $user = User::create($validatedData);
            // Upload image
            ImageManager::uploadSingleImage($request, $user);

            // Redirect with success message
            setFlashMessage('success', 'User Created Successfully');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            setFlashMessage('error', 'User Created Faild');
            return redirect()->back()->withInput();
        }

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the user in the database
        $user = User::findOrFail($id);

        // Show the user's details in the view
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        ImageManager::deleteImageInLocal($user->image);

        $user->delete();

        setFlashMessage('success', 'User Deleted Successfully');

        return to_route('dashboard.users.index');
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->status == 1) {
            $user->update([
                'status' => 0
            ]);
            setFlashMessage('success', 'User Blocked Successfully');
        } elseif ($user->status == 0) {
            $user->update([
                'status' => 1
            ]);
            setFlashMessage('success', 'User Active Successfully');
        }

        return redirect()->back();
    }

    private function prepareValidatedData(array $validatedData): array
    {
        // Convert email verification checkbox to date or null
        $validatedData['email_verified_at'] = $validatedData['email_verified_at'] == 1 ? now() : null;

        // Remove unnecessary fields
        unset($validatedData['_token'], $validatedData['password_confirmation']);

        return $validatedData;
    }
}
