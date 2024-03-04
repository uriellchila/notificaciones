<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\ContribuyenteSeeder;
use Database\Seeders\TipoDocumentoSeeder;
use Database\Seeders\TipoNotificacionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(ContribuyenteSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(TipoNotificacionSeeder::class);
        //$this->call(ElectroRegistroSeeder::class);
        //$this->call(EmsaRegistroSeeder::class);
        $this->call(MotivoDevolucionSeeder::class);
        $this->call(DocumentosSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user=User::factory()->create([
            'name' => 'Super Administrador',
            'dni' => '123456789',
            'telefono' => '70755431',
            'email' => 'admin@admin.com',
         ]);
         $role = Role::create(['name'=>'Super Admin']);
         $user->assignRole('Super Admin');
    }
}
