<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageCounter;
use Helper;
use Illuminate\Http\Request;

class HomepageCounterController extends Controller
{
    private array $module = [
        'title' => 'Homepage Counter',
        'controller_route' => 'homepage-counter',
    ];

    public function list()
    {
        echo $this->admin_after_login_layout('Homepage Counters', 'homepage-counter.list', [
            'module' => $this->module,
            'rows' => HomepageCounter::where('status', '!=', 3)->orderBy('rank')->orderBy('id')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return $this->form($request, new HomepageCounter(), 'Add Homepage Counter');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, HomepageCounter::findOrFail((int) Helper::decoded($id)), 'Edit Homepage Counter');
    }

    private function form(Request $request, HomepageCounter $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'label' => ['required', 'string', 'max:250'],
                'value' => ['required', 'integer', 'min:0'],
                'suffix' => ['nullable', 'string', 'max:20'],
                'icon' => ['nullable', 'string', 'max:100'],
                'rank' => ['nullable', 'integer', 'min:0'],
            ]);

            $row->fill($validated);
            $row->rank = $validated['rank'] ?? 0;
            $row->status = $row->exists ? $row->status : 1;
            $row->save();

            return redirect('admin/homepage-counter/list')->with('success_message', 'Homepage counter saved successfully.');
        }

        echo $this->admin_after_login_layout($title, 'homepage-counter.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
        ]);
    }

    public function delete(string $id)
    {
        HomepageCounter::whereKey((int) Helper::decoded($id))->update(['status' => 3]);

        return back()->with('success_message', 'Homepage counter deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = HomepageCounter::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Homepage counter status updated successfully.');
    }
}
