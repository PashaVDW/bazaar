@extends('layouts.profile')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Upload Signed Contract</h1>

    <form action="{{ route('profile.contract.upload.save') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="flex items-center justify-center w-full">
            <label for="contract_file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M7 16V4m0 0l-4 4m4-4l4 4m5 0v12m0 0l4-4m-4 4l-4-4" /></svg>
                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500">PDF only (max. 2MB)</p>
                </div>
                <input id="contract_file" name="contract_file" type="file" accept="application/pdf" class="hidden" required>
            </label>
        </div>

        <div class="text-right">
            <button type="submit" class="inline-block bg-primary text-white font-medium text-sm px-5 py-2.5 rounded-lg hover:bg-orange-600 transition">
                Upload Contract
            </button>
        </div>
    </form>
</div>
@endsection
