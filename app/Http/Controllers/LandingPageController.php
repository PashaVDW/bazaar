<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\LandingPage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $landingPage = Auth::user()->business->landingPage;

        if ($landingPage) {
            $landingPage->load('components');
        }

        return view('landing.index', compact('landingPage'));
    }

    public function show(string $slug): View
    {
        $landingPage = LandingPage::where('slug', $slug)->with('components')->firstOrFail();

        return view('landing.preview', compact('landingPage'));
    }

    public function create(): View
    {
        $components = Component::all();
        $componentInputDefinitions = $this->loadComponentInputDefinitions($components);

        return view('landing.create', compact('components', 'componentInputDefinitions'));
    }

    public function edit(): View
    {
        $landingPage = Auth::user()->business->landingPage()->with('components')->firstOrFail();
        $components = Component::all();
        $componentInputDefinitions = $this->loadComponentInputDefinitions($components);

        return view('landing.edit', compact('landingPage', 'components', 'componentInputDefinitions'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'slug' => [
                'required',
                'string',
                'regex:/^[a-z0-9\-]+$/i',
                'unique:landing_pages,slug',
            ],
            'logo' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:20',
            'components' => 'nullable|array',
            'components.*.id' => 'required|exists:components,id',
            'components.*.settings' => 'nullable|array',
        ]);

        $path = $request->hasFile('logo')
            ? $request->file('logo')->store('logos', 'public')
            : null;

        $landingPage = LandingPage::create([
            'business_id' => Auth::user()->business->id,
            'slug' => $request->slug,
            'logo_path' => $path,
            'primary_color' => $request->primary_color,
        ]);

        $this->syncLandingPageComponents(
            $landingPage,
            $request->input('ordered_components'),
            $request->input('components'),
            $request->input('component_settings', [])
        );

        return redirect()->route('landing.index')->with('success', 'Landing page created!');
    }

    public function update(Request $request)
    {
        $landingPage = Auth::user()->business->landingPage;

        $validated = $request->validate([
            'slug' => [
                'required',
                'string',
                'regex:/^[a-z0-9\-]+$/i',
                'unique:landing_pages,slug,'.$landingPage->id,
            ],
            'logo' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:20',
            'components' => 'nullable|array',
            'components.*.id' => 'required|integer|exists:components,id',
            'components.*.settings' => 'nullable|array',
        ]);

        if ($request->hasFile('logo')) {
            $landingPage->logo_path = $request->file('logo')->store('logos', 'public');
        }

        $landingPage->slug = $validated['slug'];
        $landingPage->primary_color = $validated['color'] ?? null;
        $landingPage->save();

        $landingPage->components()->detach();

        $this->syncLandingPageComponents(
            $landingPage,
            $request->input('ordered_components'),
            $validated['components'] ?? []
        );

        return redirect()->route('landing.index')->with('success', 'Landing page updated!');
    }

    protected function loadComponentInputDefinitions($components): array
    {
        $definitions = [];

        foreach ($components as $component) {
            $path = str_replace('.', '/', $component->view_path);
            $file = resource_path("views/{$path}.blade.php");

            if (File::exists($file)) {
                $content = File::get($file);
                if (preg_match('/\$__inputs\s*=\s*(\[.*?\]);/s', $content, $matches)) {
                    try {
                        $inputs = eval('return '.$matches[1].';');
                        $definitions[$component->id] = is_array($inputs) ? $inputs : [];
                    } catch (\Throwable $e) {
                        $definitions[$component->id] = [];
                    }
                }
            }
        }

        return $definitions;
    }

    protected function syncLandingPageComponents($landingPage, string $ordered, array $components)
    {
        $orderedIds = explode(',', $ordered);
        $componentsById = collect($components)->keyBy('id');

        foreach ($orderedIds as $index => $id) {
            if (! isset($componentsById[$id])) {
                continue;
            }

            $settings = $componentsById[$id]['settings'] ?? null;

            $landingPage->components()->attach($id, [
                'order' => $index,
                'settings' => $settings ? json_encode($settings) : null,
            ]);
        }
    }

    protected function syncLandingPageComponentsFromEdit($landingPage, array $components): void
    {
        $landingPage->components()->detach();

        foreach ($components as $index => $data) {
            $landingPage->components()->attach($data['id'], [
                'order' => $index,
                'settings' => isset($data['settings']) ? json_encode($data['settings']) : null,
            ]);
        }
    }
}
