<?php

namespace App\Http\Livewire;

use App\Models\Resume;
use Livewire\Component;
use Livewire\WithPagination;
class ResumeTable extends Component
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
        $resumes = Resume::orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
            ->simplePaginate($this->perPage);

        return view('livewire.resume-table', [
            'resumes' => $resumes,
        ]);
    }
}
