<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use HTMLPurifier_Config;
use HTMLPurifier;
use Illuminate\Support\Facades\Gate;
use App\Models\Announcement;
use App\Models\Page;
use App\Policies\AnnouncementPolicy;
use App\Policies\PagePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('markdown', function(){
            $env = new Environment();
            $env->addExtension(new GithubFlavoredMarkdownExtension());
            return new MarkdownConverter($env);
        });
        $this->app->singleton('html.purifier', function(){
            $config = HTMLPurifier_Config::createDefault();
            $config->set('Cache.DefinitionImpl', null);
            return new HTMLPurifier($config);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    Gate::policy(Announcement::class, AnnouncementPolicy::class);
    Gate::policy(Page::class, PagePolicy::class);
    }
}
