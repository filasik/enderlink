<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function before(?User $user)
    {
        if ($user) return null;
        return false;
    }

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Page $page): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, Page $page): bool { return true; }
    public function delete(User $user, Page $page): bool { return true; }
}
