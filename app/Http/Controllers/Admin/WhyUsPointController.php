<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyUsPoint;
use Helper;
use Illuminate\Http\Request;

class WhyUsPointController extends Controller
{
    private array $module = [
        'title' => 'Why Us Point',
        'controller_route' => 'why-us-point',
    ];

    public function list()
    {
        $data = [
            'module' => $this->module,
            'rows' => WhyUsPoint::where('status', '!=', 3)->orderBy('rank')->orderBy('id')->get(),
        ];

        echo $this->admin_after_login_layout('Why Us Points', 'why-us-point.list', $data);
    }

    public function add(Request $request)
    {
        return $this->form($request, new WhyUsPoint(), 'Add Why Us Point');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, WhyUsPoint::findOrFail((int) Helper::decoded($id)), 'Edit Why Us Point');
    }

    private function form(Request $request, WhyUsPoint $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:250'],
                'description' => ['nullable', 'string'],
                'icon' => ['nullable', 'string', 'max:100'],
                'rank' => ['nullable', 'integer', 'min:0'],
            ]);

            $row->fill($validated);
            $row->rank = $validated['rank'] ?? 0;
            $row->status = $row->exists ? $row->status : 1;
            $row->save();

            return redirect('admin/why-us-point/list')->with('success_message', 'Why Us point saved successfully.');
        }

        echo $this->admin_after_login_layout($title, 'why-us-point.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
        ]);
    }

    public function delete(string $id)
    {
        WhyUsPoint::whereKey((int) Helper::decoded($id))->update(['status' => 3]);

        return back()->with('success_message', 'Why Us point deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = WhyUsPoint::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Why Us point status updated successfully.');
    }
}
