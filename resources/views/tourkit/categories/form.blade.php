<x-app-layout>
    @php $isEdit = isset($category->id) ? true : false @endphp
    <div class="container mt-4">
        <form action="{{ ($isEdit) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-primary text-white">
                    <strong>{{ ($isEdit) ? 'Edit Category' : 'Add Category' }}</strong>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $category ? $category->title : '') }}" placeholder="Enter category title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">{{ ($isEdit) ? 'Update Category' : 'Add Category' }}</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Back</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
