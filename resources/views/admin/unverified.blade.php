<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
                <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
                <div class="col-md-5 info pt-3">
                    <div class="">
                        <form action="{{route('admin.search')}} " method="GET">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="status" value="pending" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="search" class="form-control" placeholder="search by name, city or state">
                            </div>
                            <button class="btn btn-primary">Search</button>
                        </form>
                    </div>

                    <!-- on desktop screens, this will be visible -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table border="1" class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden"> 
                            <thead class="bg-gray-100">
                                <tr class="hover:bg-gray-50"s>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">S/N</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Parish Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Parish Location</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Parish Email</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">State</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Date Registered</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                                    {{-- <th>Action</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parishes  as $parish)
                                    <tr data-id="{{ $parish->id }}">
                                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm">{{$parish->name}}</td>
                                        <td class="px-4 py-3 text-sm">{{$parish->address}}</td>
                                        <td class="px-4 py-3 text-sm">{{$parish->email}}</td>
                                        <td class="px-4 py-3 text-sm">{{$parish->state}}</td>
                                        <td class="px-4 py-3 text-sm">{{$parish->created_at->format('Y-m-d')}}</td>
                                        <td>{{$parish->status}}</td>
                                        <td>
                                            <form action="{{route('parish.update', $parish->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select status-select" data-id="{{ $parish->id }}">
                                                    <option value="pending" {{$parish->status == 'pending' ? 'selected': ''}}>Pending</option>
                                                    <option value="verified" {{$parish->status == 'verified' ? 'selected': '' }}>Verify</option>
                                                    <option value="suspended" {{$parish->status == 'suspended' ? 'selected': ''}}>Suspend</option>
                                                </select>
                                                <button 
                                                    type="button"
                                                    onclick="updateStatus(this, {{$parish->id}})"
                                                    class="btn btn-success">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- on mobile screens, this will be visible -->
                    <x-admin.parish-card :parishes="$parishes">
                    </x-admin.parish-card>
                </div>
                {{ $parishes->links() }}
            </div>
        </div>
    
    </div>

    <script>

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
                if(data.success){
                    console.log(data);
                    if(data.status == 'verified' && container){
                        container.remove()
                    }else{}
                    Toastify({
                        text: "Status updated successfully",
                        duration: 3000,
                        gravity:"top",
                        position:"right",
                        backgroundColor: "green",

                    }).showToast();
                }else{
                    console.error(error)
                    alert('Error encountered, try again later');
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

