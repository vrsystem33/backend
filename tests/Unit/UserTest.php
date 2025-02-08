<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Models\Users\User;
// use App\Models\Companies\Company;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_database_connection()
    {
        $this->assertTrue(DB::connection()->getPdo());
    }

    /**
     * A basic unit test example for the user model.
     */
    public function test_can_list_all_users()
    {
        // $companySuper = Company::factory()->withSuperPersonInfo()->create();

        // Crie alguns usuários de teste (opcional, se você já tiver usuários no banco)
        // User::factory()->state(['company_id' => $companySuper->id])->super()->count(2)->create();

        // Obtenha todos os usuários
        $users = User::all();

        // Verifique se a consulta retornou uma coleção
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $users);

        // Verifique se a quantidade de usuários é a esperada
        $this->assertCount(5, $users);

        // Verifique se os dados de um usuário estão corretos (ajuste de acordo com seus atributos)
        $user = $users->first();

        $this->assertTrue($user);

        // $this->assertEquals('John Doe', $user->name);
        // $this->assertEquals('johndoe@example.com', $user->email);
    }
}
