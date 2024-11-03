<x-app-layout>
    <div class="max-w-xl mx-auto p-4">
        <a href="{{ route('posts.index') }}">Back to Index</a>
        <div class="mt-6">
            @unless($post->created_at->eq($post->updated_at))
            <span class="text-sm text-gray-600">(edited)</span>
            @endunless
            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('patch')
                <div class="flex">
                    <x-text-input name="content" placeholder="What??" class="w-full" value="{{ old('content', $post->content) }}"></x-text-input>
                    <x-primary-button class="ml-px">Save</x-primary-button>
                </div>
                <x-input-error :messages="$errors->get('content')" />
            </form>
            <div class="mt-4 flex justify-end">
                <form method="POST" action="{{ route('posts.delete', $post) }}">
                    @csrf
                    @method('delete')
                    <x-secondary-button type="submit" class="h-11">Delete the Post</x-secondary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
