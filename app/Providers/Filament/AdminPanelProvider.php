<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Admin\Widgets\CalendarWidget;
use App\Filament\Admin\Widgets\CategoryChartWidget;
use App\Filament\Admin\Widgets\MoodChartWidget;
use App\Filament\Admin\Widgets\PomodoroWidget;
use App\Filament\Admin\Widgets\QuoteWidget;
use App\Filament\Admin\Widgets\StatsOverviewWidget;
use App\Filament\Admin\Widgets\ThreeHeroWidget;
use App\Filament\Admin\Widgets\WeeklyChartWidget;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Support\Facades\Blade;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Throwable;

final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        try {
            $brandName = settings()->get('general.site_name');
            $brandLogoHeight = settings()->get('general.site_logo_height');
        } catch (Throwable) {
            $brandName = null;
            $brandLogoHeight = null;
        }

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::hex('#6c5ce7'),
                'danger' => Color::hex('#e74c3c'),
                'warning' => Color::hex('#f39c12'),
                'success' => Color::hex('#00b894'),
                'info' => Color::hex('#00cec9'),
                'gray' => Color::Slate,
            ])
            ->favicon(file_exists($favIcon = storage_path('app/public/favicon.png')) ? asset('storage/favicon.png').'?v='.md5_file($favIcon) : null)
            ->brandLogo(file_exists($logo = storage_path('app/public/logo.png')) ? asset('storage/logo.png').'?v='.md5_file($logo) : null)
            ->brandName($brandName ?? config('app.name'))
            ->brandLogoHeight($brandLogoHeight ?? '75px')
            ->login()
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                ThreeHeroWidget::class,
                QuoteWidget::class,
                StatsOverviewWidget::class,
                WeeklyChartWidget::class,
                PomodoroWidget::class,
                CalendarWidget::class,
                MoodChartWidget::class,
                CategoryChartWidget::class,
            ])
            ->assets([
                \Filament\Support\Assets\Css::make('motivflow', '/css/motivflow.css'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::sidebar.footer',
                fn (): string => Blade::render('@include("filament.admin.hooks.sidebar-streak")'),
            )
            ->plugins([
                QuickCreatePlugin::make()
                    ->excludes([
                        // \App\Filament\Resources\UserResource::class,
                    ])
                    ->includes([
                        // \App\Filament\Resources\UserResource::class,
                    ]),
            ]);
    }
}
