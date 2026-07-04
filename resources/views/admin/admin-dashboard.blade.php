
<x-admin-layout>
    

    <div class="col-md-9">
        <h2 class="mt-4">Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
            {{-- @foreach ($parishes as $parish)
                    
            @endforeach --}}

        <div class="d-flex d-flex-row justify-content-center">
            <div class="card mt-3 bg-success mx-1" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Number Of Registerd Parishes</h5>
                    <p class="card-text text-center" style="font-size: 3rem; font-weight: 700">{{$parishes}}</p>
                    {{-- <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a> --}}
                </div>
            </div>

            <div class="card mt-4 bg-primary mx-1" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Number Of Registerd Users</h5>
                    <p class="card-text text-center" style="font-size: 3rem; font-weight: 700">{{$users}}</p>
                            {{-- <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a> --}}
                </div>
            </div>

            <div class="card mt-5 bg-secondary mx-1" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Number Of Verified Parishes</h5>
                    <p class="card-text text-center" style="font-size: 3rem;  font-weight: 700">{{$verifiedParishes}}</p>
                            {{-- <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a> --}}
                </div>
            </div>
        </div>
                


        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif
                
        @if ($errors->any())
            @foreach ($errors->all() as $err )
                <div class="alert-warning mt-3">{{$err}}</div>
            @endforeach
        @endif
        <div class="col-md-5 info pt-3">
            <form action="/admin/search" method="GET">
                @csrf
                <label>Enter name of parish</label>
                <input type='text' name='search' id='name' required placeholder='Enter name of parish here' class='form-control mt-2' value={{old('name')}}>
                @error('name')
                    <small class="alert alert-warning">{{$message}}</small>
                @enderror

                <button class='btn btn-primary mt-2'>Search</button>
            </form>
        </div>
    </div>
</x-admin-layout>

