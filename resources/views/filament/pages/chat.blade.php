<x-filament-panels::page>
    <div class="card w-full" style="height: calc(100%);" wire:poll.5s>
        <div class="card-header p-4 rounded-t-lg flex justify-between items-center"
            style="background: rgba(var(--gray-900),var(--tw-bg-opacity,1)); margin-bottom: 32px;border-radius: 10px">
            <div class="flex items-center gap-4">
                <img class="w-12 h-12 rounded-full object-cover"
                    src="{{ $chat->join_type === 'Google' ? $chat->picture : ($chat->picture ? asset($chat->picture) : asset('images/avatar/default_user.jpg')) }}"
                    alt="{{ $chat->name }}">
                <div>
                    <h4 class="text-lg font-bold">{{ $chat->name }}</h4>
                    <p class="text-sm">{{ $chat->phone ?? $chat->email }}</p>
                </div>
            </div>
        </div>

        <div class="card-body overflow-auto" id="msg_container" style="height: 100%;max-height: 400px">
            @foreach ($chat->messages as $message)
                <div class="mb-4 {{ $message->is_user_sender ? 'text-left' : 'text-right' }}">
                    <div class="inline-block p-3 rounded-full"
                        style="background: {{ $message->is_user_sender ? '#eee' : '#0e026d' }}; color: {{ $message->is_user_sender ? '#000' : '#fff' }};">
                        {{ $message->msg }}
                    </div>
                    <span class="text-xs block mt-1">
                        {{ $message->created_at->diffForHumans() }}
                    </span>
                </div>
            @endforeach
        </div>

        <div class="card-footer p-4 flex gap-4">
            <textarea class="form-control rounded flex-1" style="color: #000;resize: none" wire:model.defer="currentMessage"
                placeholder="Type your message..."></textarea>
            <button class="btn btn-primary" wire:click="sendMessage"
                style="background: #0062df; padding: 8px 40px">Send</button>
        </div>
    </div>

    <script>
        const container = document.getElementById('msg_container');
        container.scrollTop = container.scrollHeight;
    </script>

</x-filament-panels::page>
