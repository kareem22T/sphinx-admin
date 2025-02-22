<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .pagination nav>div {
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                width: 100%;
                gap: 10px
            }
        </style>
        <div class="space-y-4" wire:poll.5000ms>
            <div class="overflow-y-auto max-h-[500px] rounded-lg">
                @foreach ($this->getRequests() as $request)
                    <div class="py-4 flex gap-6 border-b" style="border-color: rgba(128, 128, 128, 0.185)">
                        <!-- User Image -->
                        <div class="relative"
                            style="display: flex;flex-direction: column;align-items: center; gap: 10px; width: 120px">
                            <img src="{{ $request->user->picture ?? asset('images/default_user.jpg') }}" alt="User Image"
                                class="w-20 h-20 rounded-lg object-cover">
                            <span
                                style="background-color: {{ match ($request->status) {
                                    1 => '#dfb200',
                                    2 => '#0062df',
                                    3 => '#34b704',
                                    4 => '#c8222c',
                                    default => '#dfb200',
                                } }}; padding: 5px; border-radius: 5px; color: white;">
                                {{ match ($request->status) {
                                    1 => 'Pending',
                                    2 => 'Confirmed',
                                    3 => 'Completed',
                                    4 => 'Uncompleted',
                                    default => 'Undefined',
                                } }}
                            </span>
                        </div>

                        <!-- Request Details -->
                        <div class="flex-1 space-y-2">
                            @if ($request->booking_details->type === 'hotel')
                                <h4 class="text-lg font-bold">Hotel: {{ $request->booking_details->hotel }}</h4>
                                <p>Room: {{ $request->booking_details->room }}</p>
                                <p>Persons: {{ $request->booking_details->persons }}</p>
                                <p>Price: {{ $request->booking_details->price }}</p>
                                <p>Discount: {{ $request->booking_details->discount_percentage ?? '0%' }}</p>
                            @elseif ($request->booking_details->type === 'tour')
                                <h4 class="text-lg font-bold">Tour: {{ $request->booking_details->tour }}</h4>
                                <p>Package: {{ $request->booking_details->package }}</p>
                                <p>Persons: {{ $request->booking_details->persons }}</p>
                                <p>Price: {{ $request->booking_details->price }}</p>
                                <p>Discount: {{ $request->booking_details->discount_percentage ?? '0%' }}</p>
                            @endif
                            <p>Phone: {{ $request->booking_details->phone }}</p>
                            <p>Email: {{ $request->user->email }}</p>
                        </div>
                        <div style="width: 80px;display: flex;flex-direction: column;gap: 16px; align-items: center;">
                            @if ($request->status != 3 && $request->status != 4)
                                <button wire:click="approve({{ $request->id }})"
                                    class="px-3 py-1 bg-green-500 text-white rounded-md"
                                    style="background-color: #56c822">
                                    {{ match ($request->status) {
                                        1 => 'Confirm',
                                        2 => 'Complete',
                                        default => 'Undefined',
                                    } }}

                                </button>
                                <button wire:click="cancel({{ $request->id }})"
                                    class="px-3 py-1 bg-red-500 text-white rounded-md"
                                    style="background-color: #c8222c">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Controls -->
            <div class="mt-4 pagination">
                {{ $this->getRequests()->links() }}
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
