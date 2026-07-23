<?php

namespace Tests\Unit;

use App\Http\Resources\UserResource;
use App\Models\User;
use Tests\TestCase;

class UserResourceTest extends TestCase
{

    public function test_user_resource_includes_metadata()
    {
        $user = User::factory()->create([
            'metadata' => [
                'person_id' => 'P123',
                'paramedic_id' => 'PAR456',
            ],
        ]);

        $resource = (new UserResource($user))->resolve();

        $this->assertArrayHasKey('metadata', $resource);
        $this->assertEquals('P123', $resource['metadata']['person_id']);
        $this->assertEquals('PAR456', $resource['metadata']['paramedic_id']);
    }
}
