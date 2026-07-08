<!-- on mobile screens, this will be visible -->
                    <div class="space-y-4 lg:hidden">
                        @foreach($parishes as $parish)

                        <div class="parish-card bg-white rounded-xl shadow-md border border-gray-200 p-5" data-id="{{ $parish->id }}">

                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-semibold text-lg">
                                    {{ $parish->name }}
                                </h3>

                                <span class="
                                    px-3 py-1 rounded-full text-sm
                                    @if($parish->status == 'verified')
                                        bg-green-100 text-green-700
                                    @elseif($parish->status == 'pending')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ ucfirst($parish->status) }}
                                </span>
                            </div>

                            <div class="space-y-2 text-sm">

                                <div>
                                    <span class="font-medium text-gray-500">Location:</span><br>
                                    {{ $parish->address }}
                                </div>

                                <div>
                                    <span class="font-medium text-gray-500">Email:</span><br>
                                    {{ $parish->email }}
                                </div>

                                <div>
                                    <span class="font-medium text-gray-500">State:</span>
                                    {{ $parish->state }}
                                </div>

                                <div>
                                    <span class="font-medium text-gray-500">Registered:</span>
                                    {{ $parish->created_at->format('Y-m-d') }}
                                </div>

                            </div>

                            <div class="mt-5">

                                <select
                                    class="status-select w-full rounded-lg border-gray-300"
                                    data-id="{{ $parish->id }}"
                                >
                                    <option value="pending" {{ $parish->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="verified" {{ $parish->status == 'verified' ? 'selected' : '' }}>
                                        Verified
                                    </option>

                                    <option value="suspended" {{ $parish->status == 'suspended' ? 'selected' : '' }}>
                                        Suspended
                                    </option>

                                </select>

                                <button
                                    onclick="updateStatus(this, {{ $parish->id }})"
                                    class="mt-3 w-full rounded-lg bg-green-600 py-2 text-white hover:bg-green-700"
                                >
                                    Update Status
                                </button>

                                
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('service.find', $parish->id) }}"
                                        class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200">
                                            View Service
                                        </a>
                            </div>

                        </div>

                        @endforeach
                    </div>