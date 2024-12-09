<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /** @test */
    public function it_can_create_a_post()
    {
        // Gửi yêu cầu POST để tạo mới
        $response = $this->postJson('/api/post', [
            'name' => '5555',
            'description' => '55555',
        ]);

        // Đảm bảo HTTP status code 200 (Created).
        $response->assertStatus(200);

        // Kiểm tra database đã lưu
        $this->assertDatabaseHas('posts', ['name' => '5555']);
    }

    /** @test validate create */
    public function it_validates_post_creation()
    {
        // Gửi yêu cầu POST với dữ liệu không hợp lệ
        $response = $this->postJson('/api/post', [
            'name' => '',
            'description' => '',
        ]);

        // Đảm bảo HTTP status code 422 (Unprocessable Entity)
        $response->assertStatus(422);

        // Đảm bảo phản hồi có thông báo lỗi
        $response->assertJsonValidationErrors(['name', 'description']);
    }

    /** @test */
    public function it_can_fetch_all_posts()
    {
        // Tạo nhiều bản ghi Post.
        Post::factory()->count(5)->create();

        // GET dũ liệu
        $response = $this->getJson('/api/post');

        // HTTP status code 200 (OK).
        $response->assertStatus(200);
        // ->assertJsonCount(5); // Kiểm tra 5 bản ghi trả về.
    }

    /** @test */
    public function test_it_can_fetch_a_single_post()
    {
        // Tạo một bài viết trong cơ sở dữ liệu
        $post = Post::factory()->create(['name' => 'Single Post']);

        // Gửi yêu cầu GET để lấy bài viết
        $response = $this->getJson('/api/post/' . $post->id);

        // Đảm bảo HTTP status code 200
        $response->assertStatus(200);

        // Đảm bảo nội dung trả về đúng
        $response->assertJsonFragment(['name' => 'Single Post']);
    }

    /** @test */
    public function it_can_update_a_post()
    {
        // Tạo một bản ghi Post.
        $post = Post::first();

        // Gửi yêu cầu PUT để cập nhật
        $response = $this->putJson('/api/post/' . $post->id, [
            'name' => 'Updated 1',
            'description' => 'Updated 1',
        ]);
        // dd($response->json());
        // Đảm bảo phản hồi trả về HTTP status code 200 (OK).
        $response->assertStatus(200);

        // Kiểm tra database đã cập nhật tên mới.
        $this->assertDatabaseHas('posts', ['name' => 'Updated 1']);
    }

    /** @test */
    public function it_can_delete_a_post()
    {
        // Lấy một bản ghi có sẵn từ DB
        $post = Post::where('id', 19)->first();

        // Nếu không tìm thấy bản ghi, dừng test
        if (!$post) {
            $this->markTestSkipped('No post found with id 22');
            return;
        }

        // Kiểm tra xem có data nào không.
        $this->assertNotNull($post, 'No found with id');

        // DELETE để xóa
        $response = $this->deleteJson('/api/post/' . $post->id);

        // HTTP status code 200
        $response->assertStatus(200);

        // Kiểm tra database đã xóa món ăn này.
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test page not found */
    public function it_returns_404_if_post_not_found()
    {
        // Gửi yêu cầu GET với một ID không tồn tại
        $response = $this->getJson('/api/post/999999');

        // Đảm bảo HTTP status code 404 (Not Found)
        $response->assertStatus(404);
    }
}
