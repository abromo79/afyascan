<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_product_can_be_created(): void
    {
        $this->post(route('admin.products.store'), [
            'name' => 'Screening Assistant',
            'label' => 'AI Screening',
            'short_description' => 'A short summary of the product.',
            'description' => 'A longer description of the product.',
            'features' => "First feature\nSecond feature",
            'display_order' => 3,
            'is_published' => '1',
        ])->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Screening Assistant',
            'slug' => 'screening-assistant',
            'is_published' => true,
            'display_order' => 3,
        ]);

        $this->get(route('products'))->assertOk()->assertSee('Screening Assistant');
    }

    public function test_product_can_be_updated(): void
    {
        $product = Product::factory()->create(['name' => 'Old Name']);

        $this->put(route('admin.products.update', $product), [
            'name' => 'New Name',
            'display_order' => 5,
        ])->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Name',
            'display_order' => 5,
            'is_published' => false,
        ]);
    }

    public function test_product_can_be_toggled_between_published_and_unpublished(): void
    {
        $product = Product::factory()->create(['is_published' => true]);

        $this->patch(route('admin.products.publish', $product));

        $this->assertFalse($product->fresh()->is_published);

        $this->patch(route('admin.products.publish', $product));

        $this->assertTrue($product->fresh()->is_published);
    }

    public function test_product_can_be_deleted(): void
    {
        $product = Product::factory()->create();

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_requires_a_name(): void
    {
        $this->post(route('admin.products.store'), [])->assertSessionHasErrors('name');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_features_are_parsed_into_a_list(): void
    {
        $product = Product::factory()->create([
            'features' => "  First feature  \n\n Second feature \n",
        ]);

        $this->assertSame(['First feature', 'Second feature'], $product->featureList());
    }
}
