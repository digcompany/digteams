<?php

namespace App\Http\Livewire;

use App\Contracts\CreatesDatabase;
use Auth;
use Livewire\Component;

class CreateDatabaseForm extends Component
{
    public $state = [];

    public $creatingNewDatabase = false;

    public function createDatabase(CreatesDatabase $creator)
    {
        $this->resetErrorBag();

        $creator->create($this->user, $this->state);

        $this->creatingNewDatabase = false;
    }

    public function showForm()
    {
        $this->creatingNewDatabase = true;
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.create-database-form');
    }
}
