<div> {{-- 🔥 ROOT ELEMENT SHART --}}
    @if($post)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded w-1/3">
                <h2 class="text-xl font-bold">{{ $post['title'] }}</h2>
                <p class="mt-2">{{ $post['description'] }}</p>

                <button
                    wire:click="close"
                    class="mt-4 px-4 py-2 bg-red-500 text-white rounded"
                >
                    Close
                </button>
            </div>
        </div>
    @endif
</div>
