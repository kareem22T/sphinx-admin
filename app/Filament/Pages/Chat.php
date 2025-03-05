<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Message;
use App\Models\User;
use App\Traits\PushNotificationTrait;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';
    protected static string $view = 'filament.pages.chat';
    protected static bool $shouldRegisterNavigation = false;

    public $chat;
    public $currentMessage;

    public function mount($userId)
    {
        $this->chat = User::with('messages')->findOrFail($userId);
        $this->markMessagesAsSeen();
    }

    public function markMessagesAsSeen()
    {
        foreach ($this->chat->messages as $message) {
            if (!$message->seen) {
                $message->seen = true;
                $message->save();
            }
        }
    }

    public function sendMessage()
    {
        $this->validate(['currentMessage' => 'required']);

        $message = Message::create([
            'msg' => $this->currentMessage,
            'user_id' => $this->chat->id,
            'is_user_sender' => false,
            'type' => 1,
        ]);

        $this->currentMessage = '';

        $trait = new class {
            use PushNotificationTrait;
        };

        $trait->pushNotification(
            "New Message",
            $message->msg,
            null,
            'MsgUser_' . $message->user_id,
        );

        $this->refreshChat();
    }

    public function refreshChat()
    {
        $this->chat = User::with('messages')->find($this->chat->id);
    }
}
