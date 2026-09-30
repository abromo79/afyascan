<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        return view('admin.partners.index', [
            'partners' => Partner::ordered()->get(),
            'partnershipTypes' => $this->partnershipTypes(),
        ]);
    }

    public function create(): View
    {
        return view('admin.partners.form', [
            'partner' => new Partner,
            'partnershipTypes' => $this->partnershipTypes(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->partnerData($request);

        $data['is_active'] = $request->boolean('is_active');
        $data['logo'] = $this->storeImage($request->file('logo'), 'partners');

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner created.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.form', [
            'partner' => $partner,
            'partnershipTypes' => $this->partnershipTypes(),
        ]);
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->partnerData($request);

        $data['is_active'] = $request->boolean('is_active');
        $data['logo'] = $this->storeImage($request->file('logo'), 'partners', $partner->logo);

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated.');
    }

    public function publish(Partner $partner): RedirectResponse
    {
        $partner->update(['is_active' => ! $partner->is_active]);

        return back()->with('success', $partner->is_active ? 'Partner activated.' : 'Partner deactivated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->deleteImage($partner->logo);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function partnerData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'partnership_type' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);
    }

    /**
     * @return array<int, string>
     */
    private function partnershipTypes(): array
    {
        return [
            'Healthcare & Research',
            'Technology & AI',
            'Academic & Innovation',
            'Community & Health',
            'Clinical',
            'Strategic',
        ];
    }
}
