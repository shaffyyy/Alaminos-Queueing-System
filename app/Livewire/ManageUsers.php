<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class ManageUsers extends Component
{
    public $search = '';
    public $usertype = '';

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->usertype !== '', function ($query) {
                $query->where('usertype', $this->usertype);
            })
            ->get();

        return view('livewire.manage-users', ['users' => $users]);
    }
}
