
<x-admin-layout>


    <div class="row mt-4">
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
            <div class="hidden lg:block overflow-x-auto">
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
                            <td class="px-6 py-4 text-sm text-blue-600">
                                {{$parish->state}}
                            </td>
                            <td td class="px-6 py-4 text-sm text-gray-700">{{$parish->created_at->format('Y-m-d')}}</td>
                            <td class="px-6 py-4 text-center status-cell">
                                <span class="status-badge px-3 py-1 text-xs font-semibold rounded-full
                                    @if($parish->status == 'verified') bg-green-100 text-green-700
                                    @elseif($parish->status == 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($parish->status) }}
                                </span>
                            </td>
                            <td>
                                    <select name="status" class="status-select form-select" data-id="{{ $parish->id }}">
                                        <option value="pending" {{$parish->status == 'pending'? 'selected': ''}}>Pending</option>
                                        <option value="verified" {{$parish->status == 'verified'? 'selected': ''}}>Verify</option>
                                        <option value="suspended" {{$parish->status == 'suspended'? 'selected': ''}}>Suspended</option>
                                    </select>
                                    <button type="button"
                                        onclick="updateStatus(this, {{$parish->id}})"
                                        class="btn btn-success mt-1">
                                        Update
                                    </button>
                                
                            </td>
                            <td>
                                    <form action="{{route('parish.destroy', $parish->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
        </table>
            </div>
        
        <x-admin.parish-card :parishes="$parishes">
        </x-admin.parish-card>
            {{$parishes->links()}}
    </div>

    <div id="messageDiv"></div>
    <script>
    const badgeStyles = {
        verified: 'bg-green-100 text-green-700',
        pending: 'bg-yellow-100 text-yellow-700',
        suspended: 'bg-red-100 text-red-700',
    };

    async function updateStatus(button, parishId) {
            try{
                const container = button.closest('tr') || button.closest('.parish-card');// Get the parent row or card container
                const select = container.querySelector(`.status-select`);
                const status = select.value;

                const response= await fetch(`/admin/${parishId}`, {
                    method: 'PUT',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({status})
                })

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Something went wrong');
                }
                if(data.success){
                    console.log(data);
                    const badge = container.querySelector('.status-badge');
                    if (badge) {
                        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        badge.className = `status-badge px-3 py-1 text-xs font-semibold rounded-full ${badgeStyles[status]}`;
                    }
                    Toastify({
                        text: "Status updated successfully",
                        duration: 3000,
                        gravity:"top",
                        position:"right",
                        backgroundColor: "green",

                    }).showToast();
                }else{
                    console.error(data.message || 'Update failed')
                    Toastify({
                        text: "Error encountered,try again",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "red"
                    }).showToast();
                }
            }catch(error){
                console.log('Error:', error);

                Toastify({
                    text: "Network error",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        }
    </script>

</x-admin-layout>