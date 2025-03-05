<?php

namespace App\Filament\Resources\NotificationResource\Pages;

use App\Filament\Resources\NotificationResource;
use App\Traits\PushNotificationTrait;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;
    protected function afterCreate(): void
{
    $this->record->refresh();

    $trait = new class {
        use PushNotificationTrait;
    };

    $trait->pushNotification(
        $this->record->title,
        $this->record->body,
        $this->record->user_id
    );
}

}
