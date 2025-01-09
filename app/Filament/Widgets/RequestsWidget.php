<?php

namespace App\Filament\Widgets;

use App\Models\Booking\Request;
use Filament\Widgets\Widget;
use Livewire\WithPagination;

class RequestsWidget extends Widget
{
    use WithPagination;

    protected static string $view = 'filament.widgets.requests-widget';

    protected int | string | array $columnSpan = 1;

    public int $perPage = 5; // Number of items per page

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function getRequests()
    {
        // Paginate requests
        return Request::with('user')->orderBy('id', 'desc')->paginate($this->perPage);
    }


    public function approve($id)
    {
        $request = Request::find($id);
        if ($request) {
            $request->update(['status' => $request->status + 1]);
        }
    }

    public function cancel($id)
    {
        $request = Request::find($id);
        if ($request) {
            $request->update(['status' => 4]);
        }
    }
}
