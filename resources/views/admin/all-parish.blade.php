
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
                    <td td class="px-6 py-4 text-sm text-gray-700">{{$parish->created_at->format('Y-m-d')}}</td>
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
                        <form action= "{{ route('parish.update', $parish->id)}}"method="POST" class="update-form" data-id="{{ $parish->id }}">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select">
                                <option value="pending" {{$parish->status == 'pending'? 'selected': ''}}>Pending</option>
                                <option value="verified" {{$parish->status == 'verified'? 'selected': ''}}>Verify</option>
                                <option value="suspended" {{$parish->status == 'suspended'? 'selected': ''}}>Suspended</option>
                            </select>
                            <button type="submit" class="btn btn-success mt-1">Update</button>
                        </form>
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
            {{$parishes->links()}}
    </div>

    <div id="messageDiv"></div>
    <script>
        document.querySelectorAll('.update-form').forEach(form => {
            form.addEventListener('submit', function(e) {
            e.preventDefault();

            const parishId = this.dataset.id;
            const status = this.querySelector('.form-select').value;
            const messageDiv = document.getElementById('messageDiv')
            const row = this.closest('tr'); // Get the parent row

            console.log(parishId)
            fetch(`/admin/${parishId}`, {
                method: 'PUT',
                headers: { 
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                    'content-type': 'application/json'
                },
                body: JSON.stringify({status: status})
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    const statusCell = row.querySelector('td:nth-child(6)'); // 6th column is status
                    statusCell.textContent = status;
                    messageDiv.innerHTML = `<p>${data.message}</p>`
                    console.log(data)
                }else{
                    messageDiv.innerHTML = `<p style='color:red'>${data.error}</p>`
                }
            })
            .catch(err => {
                messageDiv.innerHTML = `<p style='color:red'>Error updating status</p>`;
                console.log(err);
            });
        })
    })
    </script>

</x-admin-layout>