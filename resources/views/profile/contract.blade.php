@extends('layouts.profile')

@section('content')
<section class="py-8 bg-blueGray-50">
  <div class="container px-4 mx-auto">
    @if($business && $business->contract_file_path)
      <div class="flex flex-col md:flex-row w-full bg-white rounded-3xl overflow-hidden mb-6">
        <div class="flex items-center h-32 p-5 md:pl-14 md:w-2/5">
          <i class="fa-solid fa-file-pdf text-primary text-4xl mr-6"></i>
          <a class="inline-block text-lg font-heading font-medium leading-5 hover:underline"
             href="{{ Storage::url($business->contract_file_path) }}" target="_blank">
            Signed Contract (PDF)
          </a>
        </div>

        <div class="flex flex-1 items-center justify-end h-32 p-5 border-t md:border-t-0 md:border-l border-gray-100">
          <div class="flex items-center text-sm text-darkBlueGray-400">
            <i class="fa-regular fa-clock mr-2 text-primary"></i>
            <span>{{ $uploadTime }}</span>
          </div>
          <div class="w-px h-8 mx-4 bg-gray-100"></div>
          <div class="flex items-center text-sm text-darkBlueGray-400">
            <i class="fa-solid fa-file mr-2 text-primary"></i>
            <span>{{ $fileSize . ' MB' }}</span>
          </div>
        </div>

        <div class="flex items-center justify-center h-32 p-5 border-t md:border-t-0 md:border-l border-gray-100">
          <a class="text-primary hover:text-primary"
             href="{{ Storage::url($business->contract_file_path) }}"
             download>
            <i class="fa-solid fa-download text-xl"></i>
          </a>
        </div>
      </div>
      <div class="w-full bg-white rounded-3xl shadow px-6 py-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Upload a Signed Contract</h2>
        <p class="text-gray-600 mb-4">
          Download the contract signed by the administrator and sign it. Then upload it here. <br/> This contract is essential for your business to operate on our platform.
        </p>
        <form action="{{ route('profile.contract.upload.save') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <label for="contract_file"
                class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-blue-400 rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 transition">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <i class="fa-solid fa-upload text-3xl text-blue-500 mb-2"></i>
              <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag a file here</p>
              <p class="text-xs text-gray-500">PDF only (max. 2MB)</p>
              <p id="file-name" class="mt-2 text-sm text-green-600 font-medium hidden"></p>
            </div>
            <input id="contract_file" name="contract_file" type="file" accept="application/pdf" class="hidden" required>
          </label>

          <div class="text-right mt-6">
            <button type="submit"
                    class="inline-flex items-center bg-primary text-white font-medium text-sm px-5 py-2.5 rounded-lg hover:bg-orange-600 transition">
              <i class="fa-solid fa-paper-plane mr-2"></i> Upload Contract
            </button>
          </div>
        </form>
      </div>
      @else
        <div class="w-full bg-white rounded-3xl shadow p-10 text-center">
          <div class="flex flex-col items-center justify-center">
            <i class="fa-solid fa-circle-exclamation text-yellow-500 text-5xl mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
              No Signed Contract Available
            </h2>
            <p class="text-gray-600 text-lg max-w-xl">
              The administrator has not uploaded or signed a contract for your business yet. Please check back later or contact support for more information.
            </p>
          </div>
        </div>
      @endif


  </div>
</section>
@endsection
