<?php

namespace Tests\Feature\Foods;

use App\Models\Category;
use App\Models\Foods;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetListFoodsTest extends TestCase
{
    use DatabaseTransactions;
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function user_can_get_all_foods()
    {
        Foods::factory()->count(5)->create();
        // Có thể thay thế bằng cách dùng dùng seeder.
        $response = $this->get(route('food.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('foods.index');
        // $response->assertJsonCount(5);
        $response->assertViewHas('foods', function ($foods) {
            return $foods->count() === 5; // Kiểm tra 5 bản ghi
        });
    }

    public function test_create_page_loads_successfully()
    {
        Category::factory()->count(3)->create(); // Tạo 3 bản ghi Category trong database tạm thời.

        $response = $this->get(route('food.create')); // Gửi yêu cầu GET đến route `food.create`.

        $response->assertStatus(200); // Kiểm tra HTTP status trả về có phải là 200.
        $response->assertViewIs('foods.create'); // Kiểm tra view trả về có phải là `foods.create`.
        $response->assertViewHas('categories', function ($categories) { // Kiểm tra biến `categories` được truyền qua view.
            return $categories->count() === 3; // Đảm bảo biến `categories` có 3 bản ghi.
        });
    }

    public function test_store_saves_new_food()
    {
        $category = Category::factory()->create(); // Tạo một bản ghi Category.
        $data = [ // Dữ liệu mẫu hợp lệ để gửi vào store.
            'name' => 'Spicy Noodles',
            'count' => 15,
            'detail' => 'Delicious spicy noodles',
            'category_id' => $category->id,
        ];

        $response = $this->post(route('food.store'), $data); // Gửi yêu cầu POST đến route `food.store`.

        $response->assertRedirect(route('food.index')); // Kiểm tra nếu được redirect về route `food.index`.
        $response->assertSessionHas('msg', 'Food created success!!'); // Kiểm tra message trong session.
        $this->assertDatabaseHas('foods', ['name' => 'Spicy Noodles']); // Kiểm tra nếu bản ghi được lưu trong database.
    }

    public function test_store_fails_with_invalid_data()
    {
        $data = [ // Dữ liệu không hợp lệ (name quá ngắn, detail bị rỗng).
            'name' => '',
            'detail' => '',
        ];

        $response = $this->post(route('food.store'), $data); // Gửi yêu cầu POST đến route `food.store`.

        $response->assertSessionHasErrors(['name', 'detail']); // Kiểm tra lỗi trong session cho các field `name` và `detail`.
        $this->assertDatabaseCount('foods', 0); // Đảm bảo không có bản ghi nào được thêm vào database.
    }

    public function test_show_displays_food_details()
    {
        $category = Category::factory()->create(); // Tạo một bản ghi Category.
        $food = Foods::factory()->create(['category_id' => $category->id]); // Tạo một bản ghi Foods liên kết với category.

        $response = $this->get(route('food.show', $food->id)); // Gửi yêu cầu GET đến route `food.show` với id của food.

        $response->assertStatus(200); // Kiểm tra HTTP status là 200.
        $response->assertViewIs('foods.show'); // Kiểm tra view trả về là `foods.show`.
        $response->assertViewHas('food', function ($viewFood) use ($food) { // Kiểm tra biến `food` truyền qua view.
            return $viewFood->id === $food->id; // Đảm bảo biến `food` đúng là bản ghi được yêu cầu.
        });
    }

    public function test_update_food()
    {
        $food = Foods::factory()->create(['name' => 'Old Food']); // Tạo một bản ghi Foods với tên ban đầu.
        $data = [ // Dữ liệu cập nhật.
            'name' => 'Updated Food',
            'count' => $food->count,
            'detail' => $food->description,
        ];

        $response = $this->put(route('food.update', $food->id), $data); // Gửi yêu cầu PUT đến route `food.update`.

        $response->assertRedirect(route('food.index')); // Kiểm tra nếu được redirect về `food.index`.
        $response->assertSessionHas('msg', 'Foods update success!!'); // Kiểm tra message thành công trong session.
        $this->assertDatabaseHas('foods', ['name' => 'Updated Food']); // Kiểm tra database đã cập nhật bản ghi.
    }

    public function test_destroy_deletes_food()
    {
        $food = Foods::factory()->create(); // Tạo một bản ghi Foods.

        $response = $this->delete(route('food.destroy', $food->id)); // Gửi yêu cầu DELETE đến route `food.destroy`.

        $response->assertRedirect(route('food.index')); // Kiểm tra redirect về `food.index`.
        $response->assertSessionHas('msg', 'Foods deleted success!!'); // Kiểm tra message trong session.
        $this->assertDatabaseMissing('foods', ['id' => $food->id]); // Đảm bảo bản ghi đã bị xóa khỏi database.
    }
}
