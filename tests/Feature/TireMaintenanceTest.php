<?php

namespace Tests\Feature;

use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Enums\TireMaintenance\TirePositionEnum;
use App\Events\TireMaintenance\TireMaintenanceRequestCancelledEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestCompletedEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestInProgressEvent;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Tire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Jobs\NotifyUserTireMaintenanceRequestStatusJob;
use App\Jobs\TireMaintenanceRequestStatusJob;

class TireMaintenanceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Pre-create related records for fast seeding
        $user = User::factory()->create();
        $model = CarModel::factory()->create();
        $tire = Tire::factory()->create();

        // Now create 10,000 cars referencing the same user/model/tire
        Car::factory()->count(10000)->create([
            'user_id' => $user->id,
            'model_id' => $model->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
        ]);
        // Seed 100 tires for use in requests
        Tire::factory()->count(100)->create();
    }

    public function test_can_create_tire_maintenance_request()
    {
        $car = Car::inRandomOrder()->first();
        $user = $car->user;
        $tire = Tire::inRandomOrder()->first();

        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];

        $response = $this->postJson('/api/tire-maintenance', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id', 'car_id', 'user_id', 'status', 'maintenance_scheduled_at', 'created_at', 'updated_at', 'tires'
                ]
            ]);
    }

    public function test_conflict_on_duplicate_pending_or_in_progress_request()
    {
        $car = Car::inRandomOrder()->first();
        $user = $car->user;
        $tire = Tire::inRandomOrder()->first();

        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];

        // First request should succeed
        $this->postJson('/api/tire-maintenance', $payload)->assertStatus(200);
        // Second request should fail with conflict
        $this->postJson('/api/tire-maintenance', $payload)->assertStatus(409);
    }

    public function test_can_list_tire_maintenance_requests()
    {
        $car = Car::inRandomOrder()->first();
        $user = $car->user;
        $tire = Tire::inRandomOrder()->first();

        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $this->postJson('/api/tire-maintenance', $payload);

        $response = $this->getJson('/api/tire-maintenance');

        $response->assertStatus(200);
    }

    public function test_index_endpoint_filters_by_car_model()
    {
        $carModel = CarModel::factory()->create(['nomModel' => 'UniqueModelName']);
        $user = User::factory()->create();
        $tire = Tire::factory()->create();
        $car = Car::factory()->create([
            'model_id' => $carModel->id,
            'user_id' => $user->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
            'matricule' => 'ABC-123-XYZ',
        ]);
        // Create a maintenance request for this car
        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $this->postJson('/api/tire-maintenance', $payload)->assertStatus(200);

        $response = $this->getJson('/api/tire-maintenance?filters[car_model]=UniqueModelName');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_index_endpoint_filters_by_car_brand()
    {
        $brand = Brand::factory()->create(['name' => 'UniqueBrandName']);
        $carModel = CarModel::factory()->create(['brand_id' => $brand->id]);
        $user = User::factory()->create();
        $tire = Tire::factory()->create();
        $car = Car::factory()->create([
            'model_id' => $carModel->id,
            'user_id' => $user->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
            'matricule' => 'DEF-456-UVW',
        ]);
        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $this->postJson('/api/tire-maintenance', $payload)->assertStatus(200);

        $response = $this->getJson('/api/tire-maintenance?filters[car_brand]=UniqueBrandName');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_index_endpoint_filters_by_plate_number()
    {
        $carModel = CarModel::factory()->create();
        $user = User::factory()->create();
        $tire = Tire::factory()->create();
        $car = Car::factory()->create([
            'model_id' => $carModel->id,
            'user_id' => $user->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
            'matricule' => 'XYZ-999-PLT',
        ]);
        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $this->postJson('/api/tire-maintenance', $payload)->assertStatus(200);

        $response = $this->getJson('/api/tire-maintenance?filters[plate_number]=XYZ-999-PLT');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_index_endpoint_filters_by_username()
    {
        $carModel = CarModel::factory()->create();
        $user = User::factory()->create(['name' => 'UniqueUserName']);
        $tire = Tire::factory()->create();
        $car = Car::factory()->create([
            'model_id' => $carModel->id,
            'user_id' => $user->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
            'matricule' => 'GHI-789-QRS',
        ]);
        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $this->postJson('/api/tire-maintenance', $payload)->assertStatus(200);

        $response = $this->getJson('/api/tire-maintenance?filters[username]=UniqueUserName');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_can_process_tire_maintenance_request()
    {
        $car = Car::inRandomOrder()->first();
        $user = $car->user;
        $tire = Tire::inRandomOrder()->first();

        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => TirePositionEnum::FRONT_LEFT
                ],
            ],
        ];
        $createResponse = $this->postJson('/api/tire-maintenance', $payload);
        $requestId = $createResponse->json('data.id');

        $processPayload = [
            'status' => TireMaintenanceRequestStatusEnum::IN_PROGRESS->value,
        ];
        $response = $this->putJson("/api/tire-maintenance/process/{$requestId}", $processPayload);
        $response->assertStatus(200);
    }

    public function test_events_are_dispatched_on_request_lifecycle()
    {
        \Event::fake();

        $car = Car::inRandomOrder()->first();
        $user = $car->user;
        $tire = Tire::inRandomOrder()->first();

        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];

        // Create request (should dispatch submitted event)
        $createResponse = $this->postJson('/api/tire-maintenance', $payload);
        $createResponse->assertStatus(200);
        $requestId = $createResponse->json('data.id');
        \Event::assertDispatched(\App\Events\TireMaintenance\TireMaintenanceRequestSubmittedEvent::class);

        // Process to IN_PROGRESS
        $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::IN_PROGRESS->value])
            ->assertStatus(200);
        \Event::assertDispatched(TireMaintenanceRequestInProgressEvent::class);

        // Process to COMPLETED
        $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::COMPLETED->value])
            ->assertStatus(200);
        \Event::assertDispatched(TireMaintenanceRequestCompletedEvent::class);

        // Create another request to test cancellation
        $createResponse2 = $this->postJson('/api/tire-maintenance', $payload);
        $createResponse2->assertStatus(200);
        $requestId2 = $createResponse2->json('data.id');
        // Cancel
        $this->putJson("/api/tire-maintenance/process/{$requestId2}", ['status' => TireMaintenanceRequestStatusEnum::CANCELLED->value])
            ->assertStatus(200);
        \Event::assertDispatched(TireMaintenanceRequestCancelledEvent::class);
    }

    public function test_jobs_are_dispatched_by_listeners_on_request_lifecycle()
    {
        \Queue::fake();

        $car = Car::inRandomOrder()->first();
        $user = $car->user;
        $tire = Tire::inRandomOrder()->first();

        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];

        // Create request (should dispatch jobs via listener)
        $createResponse = $this->postJson('/api/tire-maintenance', $payload);
        $createResponse->assertStatus(200);
        $requestId = $createResponse->json('data.id');
        \Queue::assertPushed(NotifyUserTireMaintenanceRequestStatusJob::class);
        \Queue::assertPushed(TireMaintenanceRequestStatusJob::class);

        // Process to IN_PROGRESS
        $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::IN_PROGRESS->value])
            ->assertStatus(200);
        \Queue::assertPushed(NotifyUserTireMaintenanceRequestStatusJob::class);
        \Queue::assertPushed(TireMaintenanceRequestStatusJob::class);

        // Process to COMPLETED
        $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::COMPLETED->value])
            ->assertStatus(200);
        \Queue::assertPushed(NotifyUserTireMaintenanceRequestStatusJob::class);
        \Queue::assertPushed(TireMaintenanceRequestStatusJob::class);

        // Create another request to test cancellation
        $createResponse2 = $this->postJson('/api/tire-maintenance', $payload);
        $createResponse2->assertStatus(200);
        $requestId2 = $createResponse2->json('data.id');
        // Cancel
        $this->putJson("/api/tire-maintenance/process/{$requestId2}", ['status' => TireMaintenanceRequestStatusEnum::CANCELLED->value])
            ->assertStatus(200);
        \Queue::assertPushed(NotifyUserTireMaintenanceRequestStatusJob::class);
        \Queue::assertPushed(TireMaintenanceRequestStatusJob::class);
    }

    public function test_process_request_changes_status()
    {
        $carModel = CarModel::factory()->create();
        $user = User::factory()->create();
        $tire = Tire::factory()->create();
        $car = Car::factory()->create([
            'model_id' => $carModel->id,
            'user_id' => $user->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
        ]);
        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $createResponse = $this->postJson('/api/tire-maintenance', $payload);
        $createResponse->assertStatus(200);
        $requestId = $createResponse->json('data.id');

        $inProgressResponse = $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::IN_PROGRESS->value])
            ->assertStatus(200);

        $this->assertEquals($inProgressResponse->json('data.status'), TireMaintenanceRequestStatusEnum::IN_PROGRESS->value);
    }

    public function test_process_request_completed_updates_car_last_maintenance_date()
    {
        $carModel = CarModel::factory()->create();
        $user = User::factory()->create();
        $tire = Tire::factory()->create();
        $car = Car::factory()->create([
            'model_id' => $carModel->id,
            'user_id' => $user->id,
            'front_tire_id' => $tire->id,
            'rear_tire_id' => $tire->id,
        ]);
        $payload = [
            'car_id' => $car->id,
            'user_id' => $user->id,
            'maintenance_scheduled_at' => now()->addDays(2)->toDateTimeString(),
            'tires' => [
                [
                    'tire_id' => $tire->id,
                    'position' => 'front_left',
                ],
            ],
        ];
        $createResponse = $this->postJson('/api/tire-maintenance', $payload);
        $createResponse->assertStatus(200);
        $requestId = $createResponse->json('data.id');

        // Move to IN_PROGRESS first
        $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::IN_PROGRESS->value])
            ->assertStatus(200);
        // Now complete
        $this->putJson("/api/tire-maintenance/process/{$requestId}", ['status' => TireMaintenanceRequestStatusEnum::COMPLETED->value])
            ->assertStatus(200);

        $car->refresh();
        $this->assertNotNull($car->last_maintenance_date);
        $this->assertEquals(now()->toDateString(), $car->last_maintenance_date->toDateString());
    }
}
