<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase; // Для трейта RefreshDatabase
use Illuminate\Support\Facades\Queue;// Для фасада Queue::fake()
use App\Jobs\AnalyzeUrlJob;

class AnalyzeUrlTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic unit test example.
     */
    public function testOne(): void
    {
        $user = \App\Models\User::factory()->create();
        Queue::fake();
        $urlToAnalyze = ['url' => 'https://example.com'];
        $response = $this->actingAs($user)->post('/analyze', $urlToAnalyze);
        $this->assertDatabaseHas('analyses', ['url' => 'https://example.com', 'status' => 'pending']);
        Queue::assertPushed(\App\Jobs\AnalyzeUrlJob::class, function ($job) use ($urlToAnalyze) {
            return $job->analysis->url === $urlToAnalyze['url'];
        });
        $response->assertStatus(302);
        $response->assertSessionHas('status', 'Analysis request submitted successfully!');
    }
}
