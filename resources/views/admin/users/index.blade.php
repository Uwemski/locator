<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
                <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
                <table class="table table-hover" border="1">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Date Joined</th>
                            <th>    Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $serialNo = 1    
                        ?>

        
                        @foreach ($users as $user)
                            <tr>
                                <td><?php $serialNo++?></td>
                                <td><?php $user->name?></td>
                                <td><?php $user->email?></td>
                                <td><?php $user->phone?></td>
                                <td><?php $user->created_at?></td>
                                <td>
                                    <form action="{{route('users.destroy', $user->id)}}" method="POST">
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
    </div>

</x-admin-layout>