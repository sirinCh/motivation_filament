<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // this is only needed for the installation process of the starter kit
        if (! config('app.installed')) {
            config(['settings.default' => 'array']);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Gate::policy(\App\Models\Task::class, \App\Policies\TaskPolicy::class);
        \Gate::policy(\App\Models\PomodoroSession::class, \App\Policies\PomodoroSessionPolicy::class);
        \Gate::policy(\App\Models\MediaItem::class, \App\Policies\MediaItemPolicy::class);
        \Gate::policy(\App\Models\MoodEntry::class, \App\Policies\MoodEntryPolicy::class);
        \Gate::policy(\App\Models\Goal::class, \App\Policies\GoalPolicy::class);
    }
}
