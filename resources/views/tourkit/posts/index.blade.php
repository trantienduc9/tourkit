<x-app-layout>
    <div class="container">
        <div class="bg-white p-4 mt-4 shadow-sm rounded">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Manage Posts</h5>
                <a href="{{ route('posts.create') }}" class="btn btn-success">Add Post</a>
            </div>
            <div class="row g-3 align-items-center">
                <div class="col-md-2">
                    <label for="keyword" class="form-label form-label-sm">Title</label>
                    <input type="text" id="keyword" class="shadow-sm rounded-1 " style="height: 30px;s" placeholder="Search title...">
                </div>
                <div class="col-md-2">
                    <label for="categories" class="form-label form-label-sm">Category</label>
                    <select id="categories" class="form-select form-select-sm">
                        <option value="">All</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 mt-4">
            <table id="postsTable" class="table table-striped table-bordered" style="width: 100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Views</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        $(function() {
            table = $('#postsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('posts.getData') }}',
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                        d.categories = $('#categories').val();
                    }
                },
                columns: [
                    { data: 'id', className: "text-center" },
                    { data: 'title' },
                    { data: 'categories', },
                    { data: 'view_count' },
                    { data: 'created_at' },
                    { data: 'action', className: "text-center" },
                ],
                pageLength: 10,
                searching: false,
                ordering: false,
                drawCallback: function () {
                    $('.dt-input').addClass('px-3 mr-3');
                }
            });

            $('#keyword').keyup(function() {
                table.ajax.reload();
            });

            $('#categories').change(function() {
                table.ajax.reload();
            });

            $(document).on('click', '.delete-post', function(e) {
                e.preventDefault();

                var postId = $(this).data('id'); // Get the post ID from the data-id attribute

                // Confirm the deletion with a message
                if (!confirm('Are you sure you want to delete this post?')) return;

                // Send DELETE request to the controller
                $.ajax({
                    url: `/posts/${postId}`,  // URL to delete the post
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token for security
                    },
                    success: function(response) {
                        if(response){
                            table.ajax.reload();
                            toastr.success("Post delete successfully!", "Success", {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 3000
                            });
                        }
                    },
                    error: function() {
                        toastr.error("An error occurred! Please try again.", "Error", {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#categories').select2();
        });
    </script>

</x-app-layout>
