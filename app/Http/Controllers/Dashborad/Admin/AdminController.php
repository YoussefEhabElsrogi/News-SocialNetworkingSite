<?php

namespace App\Http\Controllers\Dashborad\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Authorization;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admins');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $order_by = $request->order_by ?? 'desc';
        $sort_by = $request->sort_by ?? 'id';
        $limit_by = $request->limit_by ?? 5;

        $admins = Admin::where('id', '!=', auth()->guard('admin')->user()->id)
            ->when($request->keyword, function ($query) use ($request) {
                $query->whereAny(['name', 'email', 'username'], 'LIKE', '%' . $request->keyword . '%');
            })
            ->when(!is_null($request->status), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authorizations = Authorization::select('id', 'role')->get();
        return view('dashboard.admins.create', compact('authorizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->only(['name', 'role_id', 'username', 'status', 'email', 'password']));

        if (!$admin) {
            setFlashMessage('error', 'Something went wrong , try again latter');
            return redirect()->back()->withInput();
        }

        setFlashMessage('success', 'Admin Created Successfully...');
        return redirect()->route('dashboard.admins.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        $authorizations = Authorization::select('id', 'role')->get();
        return view('dashboard.admins.edit', compact('admin', 'authorizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $data = $request->only(['name', 'role_id', 'username', 'status', 'email']);

        if (!empty($request->password)) {
            $data['password'] = $request->password;
        }

        $isChanged = false;
        foreach ($data as $key => $value) {
            if ($admin->$key != $value) {
                $isChanged = true;
                break;
            }
        }

        if ($isChanged) {
            $admin->update($data);
            setFlashMessage('success', 'Admin Updated Successfully...');
        } else {
            setFlashMessage('info', 'No changes detected.');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);

        $admin->delete();

        setFlashMessage('success', 'Admin Deleted Successfully');

        return to_route('dashboard.admins.index');
    }

    public function changeStatus($id)
    {
        $admin = Admin::findOrFail($id);

        $newStatus = $admin->status == 1 ? 0 : 1;

        $admin->update(['status' => $newStatus]);

        $message = $newStatus == 1 ? 'Admin Activated Successfully!' : 'Admin Blocked Successfully!';
        setFlashMessage('success', $message);

        return redirect()->back();
    }
}
