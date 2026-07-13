<!-- Very little is needed to make a happy life. - Marcus Aurelius -->
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
                                        <td>
                                            <span class="status-badge px-3 py-1 text-xs font-semibold rounded-full
                                                @if($parish->status == 'verified') bg-green-100 text-green-700
                                                @elseif($parish->status == 'pending') bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif">
                                                {{ ucfirst($parish->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{route('admin.parish.update', $parish->id)}}" method="POST">
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