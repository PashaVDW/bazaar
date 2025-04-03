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
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a dusk="download-pdf"
                                href="{{ route('admin.business.export.pdf', $business->id) }}"
                                class="text-blue-600 hover:underline text-sm">
                                Download PDF
                            </a>
                            @if($business->contract_file_path)
                                <a href="{{ Storage::url($business->contract_file_path) }}"
                                   target="_blank"
                                   class="text-green-600 hover:underline text-sm">
                                    View Signed
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

