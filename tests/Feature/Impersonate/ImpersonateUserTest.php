<?php

namespace Tests\Feature\Users;

use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ImpersonateUserTest extends TestCase
{
    public function testCreatingUser()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permission = Permission::firstOrCreate(['name' => 'access_backend']);
        $role->givePermissionTo($permission);

        $admin = factory(\App\User::class)->create();

        $admin->assignRole('admin');

        $user = factory(\App\User::class)->create();
        $otherUser = factory(\App\User::class)->create();

        $this->be($otherUser);
        $res = $this->get(route('impersonate', $user->id));
        $this->assertEquals(auth()->user()->id, $otherUser->id);

        $this->be($admin);
        $res = $this->get(route('impersonate', $user->id));
        $this->assertEquals(auth()->user()->id, $user->id);

        $res = $this->get(route('impersonate.leave'));
        $this->assertEquals(auth()->user()->id, $admin->id);
    }
}
