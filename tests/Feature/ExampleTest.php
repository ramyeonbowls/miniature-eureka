<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_page_expired_uses_the_small_logo_as_favicon(): void
    {
        $response = app(ExceptionHandler::class)->render(Request::create('/'), new HttpException(419));

        TestResponse::fromBaseResponse($response)
            ->assertStatus(419)
            ->assertSee('rel="icon"', false)
            ->assertSee(asset('storage/images/logo/logo_small.png'), false);
    }

    public function test_not_found_uses_the_small_logo_as_favicon(): void
    {
        $response = app(ExceptionHandler::class)->render(Request::create('/'), new HttpException(404));

        TestResponse::fromBaseResponse($response)
            ->assertNotFound()
            ->assertSee('rel="icon"', false)
            ->assertSee(asset('storage/images/logo/logo_small.png'), false);
    }

    public function test_welcome_view_uses_the_small_logo_as_favicon(): void
    {
        $this->view('welcome')
            ->assertSee('rel="icon"', false)
            ->assertSee(asset('storage/images/logo/logo_small.png'), false);
    }
}
