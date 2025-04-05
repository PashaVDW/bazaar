@extends('layouts.profile')

@section('content')
<div class="flex">
    <aside class="w-1/4 p-6 bg-gray-100 border-r border-gray-300 ">
        <x-landing-form
            :action="route('landing.update')"
            method="POST"
            :landingPage="$landingPage"
            :components="$components"
            :componentInputDefinitions="$componentInputDefinitions"
        />
    </aside>

    <main class="flex-1 p-6">
        <h2 class="text-lg font-semibold mb-4">Live Preview</h2>
        <iframe id="preview-iframe" name="preview-iframe"
                sandbox
                data-preview-route="{{ route('component.preview.multi') }}"
                class="w-full h-[1000px] border border-gray-300 rounded bg-white"></iframe>
    </main>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    import { initLandingPageBuilder } from '@/js/landingPreview'; // zorg dat je deze hebt

    document.addEventListener('DOMContentLoaded', () => {
        const previewRoute = document.querySelector('[data-preview-route]')?.dataset.previewRoute;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (previewRoute && csrfToken) {
            initLandingPageBuilder(previewRoute, csrfToken);
        }

        document.querySelectorAll('.component-toggle').forEach(toggle => {
            toggle.addEventListener('change', () => {
                const id = toggle.dataset.componentId;
                const inputs = document.getElementById('inputs-' + id);
                if (toggle.checked) {
                    inputs?.classList.remove('hidden');
                } else {
                    inputs?.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
