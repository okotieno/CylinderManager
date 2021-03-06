<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\User;
use Tests\TestCase;

class BrandTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::find(User::factory()->create()->id);
    }

    /**
     * POST api/brands
     * @group brand
     * @test
     */

    public function user_with_permission_can_create_brand()
    {
        $brand = Brand::factory()->make();
        $this->user->givePermissionTo('create brand');
        $response = $this->actingAs($this->user, 'api')
            ->postJson('api/brands', [
                'canisterBrandName' => $brand->name,
                'canisterBrandCompanyName' => $brand->company_name,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['canisterBrandId', 'canisterBrandName'],
            'headers' => ['message']
        ]);
    }

    /**
     * GET api/brands
     * @group brand
     * @test
     */

    public function authenticated_users_can_get_brands()
    {
        $brands = Brand::factory()->count(2)->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson('api/brands');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [['canisterBrandId', 'canisterBrandName']]
        ]);

        $response->assertJsonFragment(['canisterBrandName' => $brands[0]->name]);
    }


    /**
     * GET api/brands
     * @group brand
     * @test
     */

    public function authenticated_users_can_get_brand()
    {
        $brand = Brand::factory()->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson("api/brands/{$brand->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['canisterBrandId', 'canisterBrandName']
        ]);
        $response->assertJsonFragment(['canisterBrandName' => $brand->name]);
    }


    /**
     * PATCH api/brands
     * @group brand
     * @test
     */

    public function user_with_permission_can_update_brand()
    {
        $brand = Brand::factory()->create();
        $newBrand = Brand::factory()->make();
        $this->user->givePermissionTo('update brand');
        $response = $this->actingAs($this->user, 'api')
            ->patchJson("api/brands/{$brand->id}", [
                'canisterBrandName' => $newBrand->name,
                'canisterBrandCompanyName' => $newBrand->company_name,
            ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['canisterBrandId', 'canisterBrandName'],
            'headers' => ['message']
        ]);
        $response->assertJsonFragment(['canisterBrandName' => $newBrand->name]);
    }

    /**
     * PATCH api/brands
     * @group brand
     * @test
     */

    public function user_with_permission_can_delete_brand()
    {
        $brand = Brand::factory()->create();
        $newBrand = Brand::factory()->make();
        $this->user->givePermissionTo('delete brand');
        $response = $this->actingAs($this->user, 'api')
            ->deleteJson("api/brands/{$brand->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'headers' => ['message']
        ]);
    }

}
