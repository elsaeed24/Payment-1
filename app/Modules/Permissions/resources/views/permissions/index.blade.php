<x-backend-layout title="List Roles">
    <x-slot:heading>
        <!-- Page Heading -->
        <div class="card-header py-3">
           <h1 style="display: inline-block;" class="m-0 font-weight-bold">Roles</h1>
           <a  href="{{ route('permissions.create') }}" class="btn btn-lg btn-outline-primary ml-2">Create</a>
        </div>
   </x-slot:heading>
                {{-- <x-sweet-alert type='success' />
                <x-sweet-alert type='info' />
                <x-sweet-alert type='danger' /> --}}
                {{-- <x-sweet-alert type='warning'/>
                <x-sweet-alert type='dark'/> --}}

       <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Users #</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($roles as $role )

                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td>{{ $role->created_at->toDayDateTimeString() }}</td>
                            <td>
                                <div class="d-flex justify-content-center">

                                    <a href="{{ route('permissions.show', $role->id) }}"><button
                                            class="btn btn-info btn-sm"><i class="fa-solid fa-eye" title="show"></i></button></a>
                                    <a href="{{ route('permissions.edit', $role->id) }}"><button
                                            class="btn btn-warning btn-sm mx-1"><i
                                                class="fa-solid fa-edit" title="edit"></i></button></a>

                                    <form action="{{ route('permissions.destroy', $role->id) }}" id='form_{{ $role->id }}'  method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" data_id= {{ $role->id }} class="delete btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash" title="delete"></i></button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td style="color:blue;" class="text-center" colspan="8">Not Roles Defined</td>
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


        // Swal.fire({
        //         title: 'Are you sure to delete?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //         }).then((result) => {
        //         if (result.isConfirmed) {
        //          $('#form_'+id).submit()
        //         }
        //         })

        //     })

                    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            $('#form_'+id).submit()
        }
        });
        })
    </script>

    @endpush
</x-backend-layout>
