<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;
// use App\Models\User;
use App\Models\Master\Unit;
use DB;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete semua data user, role, permission
        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'Siswa', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Angkatan', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Jurusan', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Kelas', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Pemasukan Bos', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Gol Pengeluaran', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Pembayaran SPP', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Pembayaran DSP', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Pengeluaran SPP DSP', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'RKAS', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'User', 'guard_name' => 'web' ]);
        Permission::create(['name' => 'Golongan User', 'guard_name' => 'web' ]);

        // buat role
        $kepsek = Role::create(['id' => 3, 'name' => 'Kapala Sekolah']);
        $siswa = Role::create(['id' => 2, 'name' => 'Siswa']);
        $admin = Role::create(['id' => 1, 'name' => 'Administrator']);
        $dev = Role::create(['id' => 4, 'name' => 'Developer']);
        $dev->givePermissionTo(Permission::all());

        $user = \App\Models\User::factory()->create([
            'name' => 'Agung Susilo Yudhoyono Suryo Diningrat',
            'email' => 'dev@dev.com',
            'password' => Hash::make('dev')
        ]);
        $user->assignRole($dev);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);
        $user->assignRole($admin);

        $user = \App\Models\User::factory()->create([
            'name' => 'Siswa',
            'email' => 'siswa@siswa.com',
            'password' => Hash::make('siswa')
        ]);
        $user->assignRole($siswa);

        $user = \App\Models\User::factory()->create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@kepsek.com',
            'password' => Hash::make('kepsek')
        ]);
        $user->assignRole($kepsek);
    }
}
