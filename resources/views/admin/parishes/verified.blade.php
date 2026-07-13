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
                <!-- on desktop screens, this will be visible -->
                    <x-admin.parish-table :parishes="$parishes">
                    </x-admin.parish-table>
                
                    <!-- on mobile screens, this will be visible -->
                    <x-admin.parish-card :parishes="$parishes">
                    </x-admin.parish-card>
            </div>
            <!--error: it seems paginate does not work with search or I'm doing something -->
            {{$parishes->links()}}
        </div>
    </div>
    <script>

        async function updateStatus(button, parishId){
            try{
                const container = button.closest('tr') || button.closest('.parish-card' )// Get the parent row or card container
                const select = container.querySelector(`.status-select`);
                const status = select.value;

                const response = await fetch(`/admin/${parishId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({status})
                })
                const data= await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Something went wrong');
                }
                if(data.success){
                    console.log(data)
                    if(data.status == 'pending' || data.status == 'suspended'){
                        //remove the row
                        container.remove()
                    }else{
                        const badge = container.querySelector('.status-badge');
                        if (badge) {
                            badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                            badge.className = `status-badge px-3 py-1 text-xs font-semibold rounded-full ${badgeStyles[status]}`;
                        }
                    }
                    Toastify({
                        text: data.message || "Status updated successfully",
                        duration: 3000,
                        gravity:"top",
                        position:"right",
                        backgroundColor: "green",

                    }).showToast();
                }else{
                    console.error(error)
                    Toastify({
                        text: error.message || "Error encountered,try again",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "red"
                    }).showToast();
                }
            }catch(error){
                console.log('Error:', error);
                Toastify({
                    text: "Error encountered,try again",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "red"
                }).showToast();
            }
           
        }
    </script>
</x-admin-layout>