<x-backend-layout title="Create Role">
    <x-slot:heading>
       <!-- Page Heading -->
       <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Create Role</h1>
          <a href="{{ route('permissions.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back To Show Roles</a>
      </div>
    </x-slot:heading>
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
       {{-- <div class="card-header py-3">
           <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
       </div> --}}
       <div class="card-body">
           <form action="{{ route('permissions.store') }}" method="post" enctype="multipart/form-data">
               @csrf


               <div class="form-group">
                <label for="">Role Name</label>
                   {{-- <x-form.input label="Role Name" name="name" id="name"  /> --}}
                   <input type="text" class="form-control" name="name" id="name">
                 </div>


                   <div class="form-group">

                       @foreach (config('permissions') as $ability => $label)
                       <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $ability }}">
                           <label class="form-check-label" for="flexCheckDefault">
                               {{ $label }}
                           </label>
                       </div>
                       @endforeach

                       {{-- @error('abilities')
                            <p class="invalid-feedback">{{ $message }}</p>
                       @enderror --}}
                    </div>


                     <div class="form-group">
                       <button type="submit" class="btn btn-primary">Save</button>
                    </div>

           </form>
       </div>
   </div>

   @push('js')



<script type="text/javascript">
   $(document).ready(function(){
       $('#image').change(function(e){
           var reader = new FileReader();
           reader.onload = function(e){
               $('#showImage').attr('src',e.target.result);
           }
           reader.readAsDataURL(e.target.files['0']);
       });
   });
</script>


@endpush



</x-backend-layout>
