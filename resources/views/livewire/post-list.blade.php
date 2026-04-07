<div
    x-data="{
        loading: false,
        observer: null,

        init() {
            this.createObserver()
        },

        createObserver() {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {

                    if (!@this.hasMore) return; // 🔥 STOP

                    if (entry.isIntersecting && !this.loading) {
                        this.loading = true;

                        $wire.loadMore();

                        setTimeout(() => {
                            this.loading = false;

                            this.observer.disconnect();
                            this.createObserver();
                        }, 300);
                    }
                });
            }, {
                threshold: 0.1
            });

            this.observer.observe(this.$refs.loader);
        }
    }"
    class="max-w-6xl mx-auto p-6"
>

    {{-- TITLE --}}
    <h1 class="text-2xl font-bold mb-6 text-black">
        Posts ({{ count($this->filteredPosts) }})
    </h1>

    {{-- SEARCH --}}
    <div class="mb-6">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search posts..."
            class="w-full p-3 rounded-xl bg-zinc-800 border border-zinc-700 text-white"
        >
    </div>

    {{-- LIST --}}
    <div
        :class="loading ? 'opacity-50' : ''"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 transition-opacity duration-300"
    >
        @foreach($this->filteredPosts as $post)
            <div
                wire:key="post-{{ $post['id'] }}"
                wire:click="selectPost({{ $post['id'] }})"
                class="bg-zinc-900 hover:bg-zinc-800 p-5 rounded-2xl cursor-pointer transition"
            >
                <h2 class="text-lg font-semibold text-white mb-2">
                    {{ $post['title'] }}
                </h2>

                <p class="text-sm text-zinc-400">
                    {{ $post['description'] }}
                </p>

                <div class="mt-4 text-xs text-blue-400">
                    Click to view →
                </div>
            </div>
        @endforeach
    </div>

    {{-- LOADER --}}
    <div
        x-ref="loader"
        class="h-32 mt-10 flex flex-col items-center justify-center text-gray-400"
    >
        @if($hasMore)
        <template x-if="loading">
            <div class="flex flex-col items-center gap-2">
                <div class="w-6 h-6 border-2 border-gray-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Loading more...</span>
            </div>
        </template>
        @elseif(count($this->filteredPosts) === 0 && $this->search !== '')
           <span>No results found</span>
        @else
            <span>No more posts</span>
        @endif
    </div>

</div>
