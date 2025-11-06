<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Analysis;
use App\Services\CrawlService;

class AnalyzeUrlJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public Analysis $analysis;

    public function __construct(Analysis $analysis)
    {
        $this->analysis = $analysis;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = $this->analysis->url;
        CrawlService::crawl($url);
        $h1Tags = CrawlService::getHTags($url, 'h1');
        $description = CrawlService::getMetaDescription($url);
        $this->analysis->update([
            'status' => 'completed',

                'h1_tags' => $h1Tags,
                'meta_description' => $description,

        ]);
    }
    public function update(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->text('h1_tags')->nullable();
            $table->text('meta_description')->nullable();
        });
    }
}
