@extends('layouts.admin')

@section('content')
   <div class="max-w-7xl mx-auto py-8 px-4 ">
    <h1 class="text-2xl font-semibold mb-6">Business Contracts</h1>

    <div class="overflow-x-auto rounded-lg drop-shadow-md bg-white">
        <table class="w-full text-sm text-left text-gray-700 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3">Company</th>
                    <th scope="col" class="px-6 py-3">Contact Person</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">KvK</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($businesses as $business)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $business->company_name }}</td>
                        <td class="px-6 py-4">{{ $business->user->name }}</td>
                        <td class="px-6 py-4">{{ $business->user->email }}</td>
                        <td class="px-6 py-4">{{ $business->kvk_number ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded {{
                                match($business->contract_status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'signed' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                }
                            }}">
                                {{ ucfirst($business->contract_status) }}
                            </span>
                                <div class="text-xs text-gray-600 py-2">
                                @if($business->contract_signed_by_admin)
                                    <i class="fa-solid fa-user-tie text-green-500 mr-1"></i> Admin<br>
                                @endif
                                @if($business->contract_signed_by_business)
                                    <i class="fa-solid fa-building text-green-500 mr-1"></i> Business
                                @endif
                            </div>
                        </td>
                      <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex flex-col space-y-1">
                                    <a dusk="download-pdf"
                                    href="{{ route('admin.business.export.pdf', $business->id) }}"
                                    class="inline-flex items-center text-orange-600 hover:underline">
                                        <i class="fa-solid fa-download mr-1"></i> Download PDF
                                    </a>
                                    @if($business->contract_file_path)
                                        <a href="{{ Storage::url($business->contract_file_path) }}"
                                        target="_blank"
                                        class="inline-flex items-center text-green-600 hover:underline">
                                            <i class="fa-solid fa-signature mr-1"></i> View Signed
                                        </a>
                                    @endif
                                </div>
                                <div class="w-full md:w-44">
                                    @if($business->contract_signed_by_admin || $business->contract_signed_by_business)
                                        <a href="{{ route('admin.upload', $business->id) }}" class="flex gap-2 items-center justify-center w-full py-2 border-2 border-dashed border-blue-400 rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 text-blue-600 transition text-xs text-center p-2">
                                            <i class="fa-solid fa-rotate-left"></i>
                                            Re-Upload Signed
                                        </a>
                                    @else
                                         <a href="{{ route('admin.upload', $business->id) }}" class="flex gap-2 items-center justify-center w-full py-2 border-2 border-dashed border-blue-400 rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 text-blue-600 transition text-xs text-center p-2">
                                            <i class="fa-solid fa-arrow-up-from-bracket text-l mb-1"></i>
                                            Upload Signed
                                         </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

