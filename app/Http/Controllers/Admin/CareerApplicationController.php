<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CareerApplicationController extends Controller
{
    public function list()
    {
        echo $this->admin_after_login_layout('Career Applications', 'career-application.list', [
            'rows' => CareerApplication::orderByDesc('id')->get(),
            'statuses' => CareerApplication::STATUSES,
        ]);
    }

    public function details(string $id)
    {
        echo $this->admin_after_login_layout('Career Application Details', 'career-application.details', [
            'row' => CareerApplication::findOrFail((int) Helper::decoded($id)),
            'statuses' => CareerApplication::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(CareerApplication::STATUSES))],
        ]);

        CareerApplication::findOrFail((int) Helper::decoded($id))->update($validated);

        return back()->with('success_message', 'Application status updated successfully.');
    }

    public function delete(string $id)
    {
        CareerApplication::findOrFail((int) Helper::decoded($id))->delete();

        return redirect('admin/career-application/list')->with('success_message', 'Career application deleted successfully.');
    }
}
