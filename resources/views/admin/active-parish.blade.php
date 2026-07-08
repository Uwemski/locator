<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
            <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
            <div class="col-md-5 info pt-3">
                <div class="">
                    <form action="{{route('admin.search')}} " method="GET">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="status" value="verified" class="form-control">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="search" class="form-control">
                        </div>
                        <button class="btn btn-primary">Search</button>
                    </form>
                </div>
                <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">S/N</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Parish Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Parish Location</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Parish Email</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">State</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Date Registered</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold uppercase">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold uppercase">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($parishes as $parish)
                                <tr class="hover:bg-gray-100 transition duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $parish->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $parish->address }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-blue-600">
                                        {{ $parish->email }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $parish->state }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $parish->created_at->format('Y-m-d') }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($parish->status == 'verified')
                                            <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                                Verified
                                            </span>
                                        @elseif($parish->status == 'pending')
                                            <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                                Pending
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                                {{ ucfirst($parish->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button
                                            onclick="updateStatus(this, {{ $parish->id }})"
                                            class="mt-3 w-full rounded-lg bg-green-600 py-2 text-white hover:bg-green-700"
                                        >
                                            Update Status
                                        </button>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('service.find', $parish->id) }}"
                                        class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200">
                                            View Service
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-admin.parish-card :parishes="$parishes">
                </x-admin.parish-card>
            </div>
            <!--error: it seems paginate does not work with search or I'm doing something -->
            {{$parishes->links()}}
        </div>
    </div>
</x-admin-layout>