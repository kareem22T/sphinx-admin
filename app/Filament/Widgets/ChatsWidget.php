<?php

namespace App\Filament\Widgets;

use App\Models\Chat;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Log;

class ChatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.chats-widget';

    public function getChats()
    {
        $chats = User::with(["messages" => function ($q) {
            $q->latest();
        }])->whereHas("messages")->take(100)->get();

        $sortedChats = $chats->sortByDesc(function ($chat) {
            $latestMessage = $chat->messages->first(); // Get the latest message from the user
            return $latestMessage ? $latestMessage->created_at : null; // Use created_at of latest message, null if no messages
        });
        Log::info($sortedChats->values()->all());
        return $sortedChats->values()->all(); // Return the collection as an array
    }

    public function refreshChats()
    {
        $this->emitSelf('refreshComponent');
    }
}
