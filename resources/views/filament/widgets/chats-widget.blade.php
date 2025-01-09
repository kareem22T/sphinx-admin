<x-filament-widgets::widget>
    <x-filament::section>
        <div>
            <style>
                .user-info {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .user-image img {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    object-fit: cover;
                }

                .chat-card {
                    /* background: #eee; */
                    padding: 10px;
                    border-radius: 5px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
            </style>

            <div wire:poll.5s>
                <h3 class="text-lg font-bold mb-4">Latest Chats</h3>

                @if (count($this->getChats()))
                    <div class="space-y-4">
                        @foreach ($this->getChats() as $chat)
                            <div class="chat-card">
                                <div class="user-info">
                                    <div class="user-image" style="position: relative">
                                        <img src="{{ $chat->picture ?? asset('images/default_user.jpg') }}"
                                            alt="User">
                                        @if ($chat->messages->where('seen', false)->count() > 0)
                                            <span class="badge bg-danger"
                                                style="position: absolute;bottom: -5px;left: -5px;background:#c8222c;width: 25px;height: 25px;border-radius: 50%;display: flex;align-items: center;justify-content: center;">
                                                {{ $chat->messages->where('seen', false)->count() }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $chat->name }}</h4>
                                        <p class="mb-0">{{ $chat->phone ?? $chat->email }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('filament.chat', $chat->id) }}" class="btn btn-primary p-1 rounded"
                                    style="background: #0062df">
                                    Chat Now
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No chats available.</p>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
