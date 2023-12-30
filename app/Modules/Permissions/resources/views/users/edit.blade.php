<x-backend-layout title="Update User">
    <x-slot:heading>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800">Eidt User</h1>
           <a href="{{ route('users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back To Show users</a>
       </div>
   </x-slot:heading>
       <!-- DataTales Example -->
       <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div> --}}
        <div class="card-body">
            <form action="{{ route('users.update' , $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="form-group">
                    {{-- <x-form.input label="Name" name="name" id="name" :value="$user->name" readonly/> --}}
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" readonly>

                  </div>

                  {{-- <div class="form-group">
                    <x-form.input label="Category Slug" name="slug" id="slug" :value="$category->slug" />
                  </div>

                  <div class="form-group">
                    <x-form.textarea label="Description" name="description" :value="$category->description" />
                    </div> --}}

                    {{-- <div class="form-group">
                        <label for="">Type</label>
                        <select name="type" class="form-control form-select" >
                            <option value="" disabled selected>Select</option>
                            <option value="freelancer" @if ($user->type == "freelancer") selected @endif>Freelancer</option>
                            <option value="client" @if ($user->type == "client") selected @endif>Client</option>

                        </select>

                     </div> --}}

                     <div class="form-group mb-3">
                        <label for="">Roles:</label>
                        <div>
                            @foreach($roles as  $label)
                            <div class="mb-1">
                                <label for="">
                                    <input type="checkbox" name="roles[]" value="{{ $label->id }}" @if(in_array($label->id,$user_role)) checked @endif>
                                    {{ $label->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        {{-- @error('abilities')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror --}}
                    </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update User</button>
                     </div>

            </form>
        </div>
    </div>

    @push('js')

<script>

$('#name').on('input', function(){
    let name = $(this).val()
    let slug = name.replaceAll(' ','-')
    $('#slug').val(slug.toLowerCase());
})
</script>

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
