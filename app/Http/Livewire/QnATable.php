<?php

namespace App\Http\Livewire;

use App\Models\QnA;
use Livewire\Component;
use Livewire\WithPagination;
class QnATable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $orderBy = 'created_at';
    public $orderDesc = true;

    /**
     * Render the view with pagination
     */
    public function render()
    {
        $qnas = QnA::orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
            ->simplePaginate($this->perPage);

        return view('livewire.qn-a-table', [
            'qnas' => $qnas
        ]);
    }
}
