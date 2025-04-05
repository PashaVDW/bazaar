@extends('layouts.profile')

@section('content')
<div class="flex">
    <aside class="w-1/4 p-6 bg-gray-100 border-r border-gray-300 ">
        <x-landing-form
            :action="route('landing.store')"
            :components="$components"
            :componentInputDefinitions="$componentInputDefinitions"
        />
    </aside>

    <main class="flex-1 p-6">
        <h2 class="text-lg font-semibold mb-4">Live Preview</h2>
        <iframe id="preview-iframe" name="preview-iframe"
                sandbox
                data-preview-route="{{ route('component.preview.multi') }}"
                class="w-full h-[1000px] border rounded bg-white"></iframe>
    </main>
</div>
@endsection
