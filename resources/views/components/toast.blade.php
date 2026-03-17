<div
    wire:ignore
    x-data="{
        messages: [],
        remove(mid) {
            this.messages = this.messages.filter(m => m.id !== mid)
        }
    }"
    @toast.window="
        let id = Date.now();
        messages.push({ id, type: $event.detail.type, text: $event.detail.text });
        setTimeout(() => remove(id), 5000);
    "
    class="fixed top-0 right-0 z-[9999] p-6 flex flex-col gap-3 w-full max-w-sm pointer-events-none"
>
    <template x-for="msg in messages" :key="msg.id">
        <div
            x-show="true"
            x-transition:enter="transform transition ease-out duration-500"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            
            :class="{
                'bg-emerald-600 border-emerald-400': msg.type === 'success',
                'bg-rose-600 border-rose-400': msg.type === 'error',
                'bg-blue-600 border-blue-400': msg.type === 'info',
                'bg-amber-600 border-amber-400': msg.type === 'warning'
            }"
            class="pointer-events-auto flex items-center justify-between gap-4 px-4 py-3 text-white rounded-xl shadow-2xl border backdrop-blur-md transition-all"
        >
            {{-- Icon & Text --}}
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <template x-if="msg.type === 'success'">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </template>
                    <template x-if="msg.type === 'error'">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                    </template>
                </div>
                <p x-text="msg.text" class="text-sm font-bold"></p>
            </div>

            {{-- HIGH VISIBILITY CLOSE BUTTON --}}
            <!-- <button 
                @click="remove(msg.id)" 
                class="group relative flex-shrink-0 p-1 rounded-full hover:bg-white/20 transition-colors focus:outline-none"
                aria-label="Close"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white opacity-90 group-hover:opacity-100" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button> -->
        </div>
    </template>
</div>