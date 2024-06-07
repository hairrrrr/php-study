<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

define('Title', 'Test Title');
define('Content', 'This is a test content.');

class NoteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     use RefreshDatabase;
     use WithFaker;

     
    //  const $title = ;
    //  $content = $this->faker->paragraph;
     public function testPostArtical(): void
     {
        $this->helper();
        // 发送 POST 请求
        $response = $this->post('/notes', [
            'title' => Title,
            'content' => Content,
        ]);

        // 断言文章是否成功插入数据库
        $note = Note::where('title', Title)->where('content', Content)->first();
        $this->assertNotNull($note);

        // 断言重定向到正确的页面
        $response->assertRedirect("/notes/{$note->id}");
    }
    

    public function testAddTagToNote(): void
    {
        $this->helper();

        /**
         * $note = Note::factory()->create();
         * 这样创建文章是访问不到的
         */

        $this->post('/notes', [
            'title' => Title,
            'content' => Content,
        ]);

        $note = Note::where('title', Title)->first();
        $this->assertNotNull($note);
        
        $tagName = 'testTag';
        $response = $this->patch("/notes/{$note->id}", [
            'title' => Title,
            'content' => Content,
            'tag' => $tagName,
        ]);
        
        // 确认标签是否存在于标签表中
        $this->assertDatabaseHas('tags', ['name' => $tagName]);

        // 确认标签是否与文章相关联
        $this->assertDatabaseHas('note_tag', [
            'note_id' => $note->id,
            'tag_id' => Tag::where('name', $tagName)->first()->id,
        ]);
        
        $response->assertRedirect("/notes/{$note->id}");
    }

    public function testSoftDeleteAndRestoreNote(): void
    {
        $this->helper();

        $this->post('/notes', [
            'title' => Title,
            'content' => Content,
        ]);

        $note = Note::where('title', Title)->first();
        $this->assertNotNull($note);

        // 软删除文章
        $response = $this->delete("/notes/{$note->id}");

        // 断言重定向到 /notes
        $response->assertRedirect('/notes');

        // 确认文章已被软删除
        $this->assertSoftDeleted('notes', ['id' => $note->id]);

        // 恢复软删除的文章
        $response = $this->patch("/trash/{$note->id}");

        // 断言重定向到 /notes/{id}
        $response->assertRedirect("/notes/{$note->id}");

        // 确认文章已恢复
        $this->assertDatabaseHas('notes', ['id' => $note->id]);
    }

    

    private function helper() 
    {
        // 创建用户并模拟登录状态
        $user = User::factory()->create();
        $this->actingAs($user);
    }
}
