<x-backend-layout title="Show User">
    <x-slot:heading>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">Show User</h1>
           <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back To show users</a>
       </div>
   </x-slot:heading>
    <!-- DataTales Example -->
       <div class="card shadow mb-4">

        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>

                    <tr>
                        <th>Title</th>
                        <td>{{ $user->freelancer->title ?? "Not Defined" }}</td>
                    </tr>



                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>



                    <tr>
                        <th>Type</th>
                        <td>{{ $user->type }}</td>
                    </tr>




                    <tr>
                        <th>Created At</th>
                        <td>{{ $user->created_at->toDayDateTimeString() }}</td>
                    </tr>

                    <tr>
                        <th>Updated At</th>
                        <td>{{ $user->created_at != $user->updated_at ? $user->updated_at->toDayDateTimeString() : 'Not Updated'  }}</td>
                    </tr>

                    <tr>
                        <th>Image</th>
                        <td>
                            <img  class="img-thumbnail post-image" data-src={{ $user->image_url }} style="width: 110px; height: 110px;" src="{{ $user->image_url }}" class="rounded mx-auto d-block">
                        </td>
                    </tr>
                </tbody>

               </table>

        </div>
    </div>


</x-backend-layout>
