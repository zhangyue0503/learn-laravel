<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZyBlogTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_example2()
    {
        $response = $this->post('/test/post');

        $response->assertStatus(200);
        $response->dump();

    }

    public function test_example3()
    {
        $response = $this->postJson('/test/post/json');

        $response->assertStatus(200)->assertJson(['a'=>1]);
    }

    public function test_example4()
    {
        $view = $this->view('test.test', ['message'=>'ZyBlog']);
        $view->assertSee("ZyBlog");
    }

    public function test_console1(){
        $this->artisan('testconsole')->expectsOutput("Hello ZyBlog")->assertExitCode(0);
    }

    public function test_console2(){
        $this->artisan('question')
            ->expectsQuestion("选择午饭", "面条")
            ->expectsOutput("你的选择是：面条")
            ->doesntExpectOutput("你的选择是：盖饭")
            ->assertExitCode(0);
    }
}
