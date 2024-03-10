<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
   protected function setUp(): void
   {
       parent::setUp();
   
       // code
     $this->user = $this->createUser();
   }
   
    public function test_home_page(): void
    {    
        
        $response = $this->actingAs($this->user);
        $response = $this->get('/products'); 
        $response->assertStatus(200);

    }
    public function test_homepage_contains_empty_table(){ 
         
        $response = $this->actingAs($this->user);
        $response = $this->get('/products'); 
        Product::create([
            'name'=>'asdf',
            'category'=>'asdf',
            'description'=>'asdf',
        ]);
        
        $response->assertStatus(200);
    }
    // public function test_user_if_authenticated(){
         

    //     $response = $this->post('/login', [
    //         'email' => $this->createUser(),
    //         'password' => 'password',
    //     ]);
 
    //     $response->assertStatus(302);
        
    //     $response->assertRedirect('/products');

    // }
    // public function test_unauthenticated_user_cannot_access_products(){
    //     $res = $this->get('/products');
    //     $res->assertStatus(302);
    //     $res->assertRedirect('/login');
    // }
    public function test_can_render_create_products(){
        $res = $this->actingAs($this->user);
        $res  = $this->get('/create-products');
        $res->assertStatus(200);
    }
    public function test_user_can_create_product(){
        // $res = $this->actingAs($this->user);
        $products = [
            'name'=>'sample 1',
            'category'=>'samplee 1',
            'description'=>'sample 1',
        ]; 
        $res = $this->actingAs($this->user)->post('/api/products/store',$products);
        // $res->assertStatus(200);
        $res->assertStatus(302);
        // $res->assertRedirect('/products');
        
        // $res->assertDatabaseHas('products',$products);

    }
    private function createUser(): User{
        return User::factory()->create();
    }
}
