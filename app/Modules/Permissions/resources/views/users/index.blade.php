<x-backend-layout title="List User">
    <x-slot:heading>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">Users</h1>
           <a href="{{ route('users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create User</a>
       </div>
   </x-slot:heading>
                {{-- <x-sweet-alert type='success' message='User Created Successfully'/>
                <x-sweet-alert type='info' message='User Updated Successfully'/>
                <x-sweet-alert type='error' message='User Deleted Successfully'/> --}}
       <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>email</th>
                            {{-- <th>Permissions</th> --}}
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user )

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- @foreach ( $user->roles as $roles)
                             <td>{{ $roles->name }}</td>
                            @endforeach --}}
                            <td>{{ $user->created_at->toDayDateTimeString() }}</td>
                            <td>{{  $user->created_at != $user->updated_at ? $user->updated_at->toDayDateTimeString() : 'Not Updated' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">

                                    <a href="{{ route('users.show', $user->id) }}"><button
                                            class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></button></a>
                                    <a href="{{ route('users.edit', $user->id) }}"><button
                                            class="btn btn-warning btn-sm mx-1"><i
                                                class="fa-solid fa-edit"></i></button></a>

                                    <form action="{{ route('users.destroy', $user->id) }}" id='form_{{ $user->id }}'  method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" data_id= {{ $user->id }} class="delete btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash"></i></button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td style="color:blue;" class="text-center" colspan="8">Not users Defined</td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')

    <script>
        $('.delete').on('click' , function(){
            let id = $(this).attr('data_id')


        Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                 $('#form_'+id).submit()
                }
                })

            })
    </script>

    @endpush
</x-backend-layout>
