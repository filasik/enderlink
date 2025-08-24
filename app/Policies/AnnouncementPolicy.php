<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    public function before(?User $user)
    {
        if ($user) return null;
        return false; // guests denied for management actions
    }

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Announcement $announcement): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, Announcement $announcement): bool { return true; }
    public function delete(User $user, Announcement $announcement): bool { return true; }
}
