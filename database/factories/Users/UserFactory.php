<?php

namespace Database\Factories\Users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\Users\User;
use App\Models\Companies\Company;
use App\Models\Employees\Employee;
use App\Models\Users\Permission;
use App\Models\Users\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users\User>
 */
class UserFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica irá gerar.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'uuid' => Str::uuid(),
            'company_id' => Company::factory(),
            'permission_id' => null,
            'role_id' => Role::factory(),
            'gallery_id' => null,
            'employee_id' => Employee::factory(),
            'username' => $this->faker->userName(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'status' => $this->faker->boolean(),
            'master' => $this->faker->boolean(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (User $user) {
            if (!$user->permission_id) {
                $user->permission_id = Permission::factory()->withCompanyId($user->company_id)->create()->uuid;
            }
        })->afterCreating(function (User $user) {
            if (!$user->permission_id) {
                $user->permission_id = Permission::factory()->withCompanyId($user->company_id)->create()->uuid;
                $user->save(); // Salva o `permission_id` após criar o usuário
            }
        });
    }

    /**
     * Define que o usuário será do tipo admin.
     *
     * @return $this
     */
    public function admin($companyId): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => Role::where('name', 'admin')->first()->id ?? Role::factory()->create(['company_id' => $companyId, 'name' => 'admin', 'description' => 'Administrador'])->id,
        ]);
    }

    /**
     * Define que o usuário será do tipo super.
     *
     * @return $this
     */
    public function super($companyId): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => Role::where('name', 'super')->first()->id ?? Role::factory()->create(['company_id' => $companyId, 'name' => 'super', 'description' => 'Super Admin'])->id,
        ]);
    }

    /**
     * Define que o usuário será do tipo employee.
     *
     * @return $this
     */
    public function employee($companyId): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => Role::where('name', 'employee')->first()->id ?? Role::factory()->create(['company_id' => $companyId, 'name' => 'employee', 'description' => 'Funcionário'])->id,
        ]);
    }

    /**
     * Define que o usuário será do tipo delivery.
     *
     * @return $this
     */
    public function delivery($companyId): static
    {
        return $this->state(fn(array $attributes) => [
            'role_id' => Role::where('name', 'delivery')->first()->id ?? Role::factory()->create(['company_id' => $companyId, 'name' => 'delivery', 'description' => 'Entregador'])->id,
        ]);
    }
}
