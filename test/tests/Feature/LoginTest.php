<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPageDisplaysLoginForm(): void
    {
        // 访问登录页面
        $response = $this->get('/login');

        // 断言页面状态码为 200
        $response->assertStatus(200);

        // 断言页面包含登录表单
        $response->assertSee('login');
        $response->assertSee('email');
    }

    public function testUserCanLoginWithValidCredentials(): void
    {
        // 创建用户
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // 使用 bcrypt 加密密码
        ]);

        // 发送 POST 请求登录
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // 断言登录成功后重定向到指定页面
        $response->assertRedirect('/notes');

        // 断言用户已经登录
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        // 发送 POST 请求使用无效的凭据登录
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalid-password',
        ]);

        // 断言登录失败
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }
}
