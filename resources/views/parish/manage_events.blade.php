<x-client-layout>

    <div class="flex-grow-1">
        <div class="container mt-4">
            <!-- Dynamic content goes here -->
            <h2 class="mb-3">Dashboard</h2>
            <p>Create and manage your events for your parish</p>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $err)
                <div class="alert alert-warning">{{$err}}</div>
            @endforeach

        @endif
        <div class="p-4 mb-4">
            <table border='1' class="table table-hover">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Event name</th>
                        <th>Description</th>
                        <th>Event date</th>
                        <th>Location</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $serialNo= 1;    
                    ?>
                    @foreach ($events as $event)
                    <tr id='event-{{$event->id}}'>
                        <td class="">{{$serialNo}}</td>
                        <td class="event-title">{{$event->title}}</td>
                        <td class="event-description">{{$event->description}}</td>
                        <td class="event-date">{{$event->event_date}}</td>
                        <td class="event-location">{{$event->location ?? "Church premises"}}</td>
                        <td>
                             <button onclick="editEvent({{$event->id}})">Edit</button>
                        </td>
                        <td>
                            <form action="{{route('event.remove', $event->id)}}" method='post'>
                                @csrf
                                @method('delete')
                                <button style='background-color: red'>Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php $serialNo++?>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="editEventContainer" style='display:none;'>
            <h3>Edit Event</h3>

            <form action="" method="POST" id="editForm">
                @csrf
                <input type="hidden" id="eventId">
                <input type="text" id="editName" required>
                <input type="text" id="editDescription" required>
                <input type="text" id="editDate" required>
                <input type="text" id="editLocation">

                <button type="submit">Update</button>
                <button type="button" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>

        <div id="resultDiv"></div>
    </div>

    <script>
        function editEvent(eventId) {
            //change display
            document.getElementById('editEventContainer').style.display = 'block';

            //get record
            fetch(`parish/event/${eventId}/edit`, {
                method: 'GET',
                'X-CSRF-TOKEN': "{{csrf_token()}}",
                'Accept': 'application/json',
                'content-type': 'application/json'
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('eventId').value = data.id
                document.getElementById('editName').value = data.title
                document.getElementById('editDescription').value = data.description
                document.getElementById('editDate').value = data.event_date
                document.getElementById('editLocation').value = data.location
                console.log(data)
            })
            .catch(error => {
                console.log(`${data.error}`)
            })
        }

        function cancelEdit() {
            document.getElementById('editEventContainer').style.display = 'none'
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const id= document.getElementById('eventId').value
            const name= document.getElementById('editName').value
            const description= document.getElementById('editDescription').value
            const date = document.getElementById('editDate').value

            fetch('url', {
                method: "PUT",
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            })
            .then(res => res.json() )
            .then(data => {
                document.getElementById('resultDiv').innerHTML = `<p>${data.message}</p>`
                
                document.querySelector('#event-${eventId} .event-title').textContent = data.data.title
                document.querySelector('#event-${eventId} .event-description').textContent = data.data.description
                document.querySelector('#event-${eventId} .event-date').textContent = data.data.event_date
                document.querySelector('#event-${eventId} .event-location').textContent = data.data.location

                document.getElementById('editEventContainer').style.display = "none"
            })
            .catch(err => {
                document.getElementById('resultDiv').innerHTML = `<p style='color:red'>Error Updating</p>`
            })
        })
    </script>
</x-client-layout>

