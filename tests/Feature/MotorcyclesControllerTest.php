<?php

namespace Tests\Feature;

use App\Motorcycle;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class MotorcyclesControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function testIndex()
    {
        $this->get('/')->assertViewHas('motorcycles');
    }

    public function testMine()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get('/motorcycles/mine')->assertViewHas('motorcycles');
    }

    public function testShow()
    {
        $motorcycle = factory(Motorcycle::class)->create();

        $this->get('/motorcycles/' . $motorcycle->id)->assertViewHas('motorcycle');
    }

    public function testCreate()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->get('motorcycles/create')->assertViewIs('motorcycles.create');
    }

    public function testStore()
    {
        $this->withoutMiddleware();

        $user = factory(User::class)->create();

        $this->actingAs($user)->post('motorcycles', [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'phone_number' => $this->faker->phoneNumber
        ])->assertRedirect('/');
    }

    public function testEdit()
    {
        $motorcycle = factory(Motorcycle::class)->create();

        $this->actingAs($motorcycle->user)->get('motorcycles/' . $motorcycle->id . '/edit')
            ->assertViewIs('motorcycles.edit')
            ->assertViewHas('motorcycle');
    }

    public function testUpdate()
    {
        $motorcycle = factory(Motorcycle::class)->create();

        $this->actingAs($motorcycle->user)->patch('/motorcycles/' . $motorcycle->id, [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'phone_number' => $this->faker->phoneNumber
        ])->assertRedirect('/');
    }

    public function testDestroy()
    {
        $motorcycle = factory(Motorcycle::class)->create();

        $this->actingAs($motorcycle->user)->delete('/motorcycles/' . $motorcycle->id)->assertRedirect('/');
        $this->assertDatabaseMissing('motorcycles', ['id' => $motorcycle->id]);
    }
}
