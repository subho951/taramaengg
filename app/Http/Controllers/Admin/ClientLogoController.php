<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\ClientLogo;
use Helper;
use Illuminate\Http\Request;

class ClientLogoController extends Controller
{
    use HandlesUploads;

    private array $module = [
        'title' => 'Client Logo',
        'controller_route' => 'client-logo',
    ];

    public function list()
    {
        echo $this->admin_after_login_layout('Client Logos', 'client-logo.list', [
            'module' => $this->module,
            'rows' => ClientLogo::where('status', '!=', 3)->orderBy('rank')->orderBy('id')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return $this->form($request, new ClientLogo(), 'Add Client Logo');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, ClientLogo::findOrFail((int) Helper::decoded($id)), 'Edit Client Logo');
    }

    private function form(Request $request, ClientLogo $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:250'],
                'website_url' => ['nullable', 'url', 'max:500'],
                'logo' => [$row->exists ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,svg,ico', 'max:4096'],
                'rank' => ['nullable', 'integer', 'min:0'],
            ]);

            $logo = $this->storeUpload($request, 'logo', 'client_logo');

            $row->fill($validated);
            $row->logo = $logo ?? $row->logo;
            $row->rank = $validated['rank'] ?? 0;
            $row->status = $row->exists ? $row->status : 1;
            $row->save();

            return redirect('admin/client-logo/list')->with('success_message', 'Client logo saved successfully.');
        }

        echo $this->admin_after_login_layout($title, 'client-logo.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
        ]);
    }

    public function delete(string $id)
    {
        ClientLogo::whereKey((int) Helper::decoded($id))->update(['status' => 3]);

        return back()->with('success_message', 'Client logo deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = ClientLogo::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Client logo status updated successfully.');
    }
}
