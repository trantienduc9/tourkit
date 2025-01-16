<x-app-layout>
    <div class="container">
        <div class="mt-4 bg-white p-4 rounded-3">
            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
        </div>
        <div class="p-4 bg-white shadow-sm rounded-3 mt-4">
            <form action="" method="POST" id="delete-category-form">
                @csrf
                @method('DELETE')
            </form>
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 40%;">Title</th>
                        <th style="width: 10%;">Posts</th>
                        <th style="width: 10%;">Views</th>
                        <th style="width: 15%;">Created At</th>
                        <th style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td><a class="text-decoration-none text-primary" href="{{ route('categories.edit', $category) }}">{{ $category->title }}</a></td>
                            <td>{{ $category->posts_count }}</td>
                            <td>{{ $category->view_count }}</td>
                            <td>{{ formatDate($category->created_at) }}</td>
                            <td class="text-center">
                                <button type="submit" d-id="{{ $category->id }}" class="btn-delete-category btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links() }}
        </div>
    </div>

    <script>
        $('.btn-delete-category').on('click', function() {
            let id = $(this).attr('d-id');

            let isConfirmed = confirm("Are you sure you want to delete it?");

            if(isConfirmed){
                let deleteUrl = "{{ route('categories.destroy', ':id') }}".replace(':id', id);
                $('#delete-category-form').attr('action', deleteUrl);
                $('#delete-category-form').submit();
            }
        })
    </script>

</x-app-layout>
