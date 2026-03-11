<?php

use App\Models\User;
use Livewire\Component;

new class extends Component
{
    public $search = '';

    public function toggleActive($id) {
        $user = User::find($id);
        $user->update(['is_active' => !$user->is_active]);
    }

    public function changeRole($id, $role) {
        User::where('id', $id)->update(['role' => $role]);
    }

    public function users() {
        return User::query()->paginate(25);
    }
};
?>

<div>
    <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search customers..." class="mb-6" />

    <flux:table :paginate="$this->users()">
        <flux:table.columns>
            <flux:table.column>User</flux:table.column>
            <flux:table.column>Role</flux:table.column>
            <flux:table.column>Active</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($this->users() as $user)
                <flux:table.row>
                    <flux:table.cell>
                        <div class="font-medium">{{ $user->name }}</div>
                        <div class="text-xs text-zinc-500">{{ $user->email }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:select wire:change="changeRole({{ $user->id }}, $event.target.value)" size="sm">
                            <option value="customer" @selected($user->role == 'customer')>Customer</option>
                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                        </flux:select>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:switch wire:click="toggleActive({{ $user->id }})" :checked="$user->is_active" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>