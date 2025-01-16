<x-app-layout>
    @php $isEdit = isset($post->id) ? true : false @endphp
    <div class="container mt-4">
        <form action="{{ ($isEdit) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-primary text-white">
                    <strong>{{ ($isEdit) ? 'Edit Post' : 'Add Post' }}</strong>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post ? $post->title : '') }}" placeholder="Enter post title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Enter post content" required>{{ old('content', $post ? $post->content : '') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- View Count -->
                    <div class="mb-4">
                        <label for="view_count" class="form-label">View Count</label>
                        <input type="number" id="view_count" name="view_count" class="form-control @error('view_count') is-invalid @enderror" value="{{ old('view_count', $post ? $post->view_count : 0) }}" min="0" required>
                        @error('view_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="categories" class="form-label">Categories</label>
                        <select id="categories" name="categories[]" class="form-select @error('categories') is-invalid @enderror" multiple required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(isset($post) && $post->categories && in_array($category->id, $post->categories->pluck('id')->toArray())) selected @endif>{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('categories')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">{{ ($isEdit) ? 'Update Post' : 'Add Post' }}</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#categories').select2();
        });
    </script>
</x-app-layout>
