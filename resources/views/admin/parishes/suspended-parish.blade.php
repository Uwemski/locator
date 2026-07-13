<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
                <h2 class="mt-4">All Suspended Parishes</h2>
                
                <div class="">
                        <form action="{{route('admin.search')}} " method="GET">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="status" value="suspended" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="search" class="form-control">
                            </div>
                            <button class="btn btn-primary">Search</button>
                        </form>
                    </div>




                <!-- on desktop screens, this will be visible -->
                    <x-admin.parish-table :parishes="$parishes">
                    </x-admin.parish-table>
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
                    }else{
                        const badge = container.querySelector('.status-badge');
                        if (badge) {
                            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                            badge.className = `status-badge px-3 py-1 text-xs font-semibold rounded-full ${badgeStyles[status]}`;
                        }
                    }
                    Toastify({
                        text: "Status updated successfully",
                        duration: 3000,
                        gravity:"top",
                        position:"right",
                        backgroundColor: "green",

                    }).showToast();
                }else{
                    console.error(data.message || 'Update failed');
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