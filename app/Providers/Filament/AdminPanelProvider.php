<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Pages\AsignarDocumentos;
use Filament\Support\Colors\Color;
use Filament\Pages\Auth\EditProfile;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\TipoNotificacion;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificacionesNoti;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificadoresChart;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\NotificacionesTabla;
use App\Filament\Resources\DocumentoResource\Widgets\EstadisticaNotificadorOverview;
use App\Filament\Resources\DocumentoResource\Widgets\NotificacionDocumentosOverview;
use App\Filament\Resources\DocumentoNotificadorResource\Widgets\TipoNotificacionChart;
use App\Filament\Resources\DevolucionDocumentoResource\Widgets\DevolucionDocumentosTable;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Purple,
                //'primary' => Color::Emerald,
            ])
            ->font('Roboto')
            //->font('Inter', provider: GoogleFontProvider::class)
            ->brandName('NOTIFICACIONES')
            ->navigationGroups([
                NavigationGroup::make('Mantenimiento')
                     ->label('mantenimiento'),
                /*NavigationGroup::make('asignardocumento')
                     ->label('mantenimientossss'),*/
                NavigationGroup::make()
                     ->label('Roles y Permisos')
                     ->collapsed('false'),
                
                
            ])
            ->navigationItems([
                NavigationItem::make()
                    ->label('Asignar')
                    ->visible(fn(): bool => Auth::user()->can('view-analytics'))
                    ->icon('heroicon-o-presentation-chart-line'),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()
            ->topbar(true)
            ->profile(EditProfile::class)
            //->profile(isSimple: false)
            ->login()
            //->registration()
            //->passwordReset()
            //->emailVerification()
            //->profile()
            ->authGuard('web')
            //->spa()
            ->unsavedChangesAlerts()
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                //Pages\AsignarDocumentos::class,
            ])
            //->path('app')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                EstadisticaNotificadorOverview::class,
                NotificacionDocumentosOverview::class,
               
                //NotificadoresChart::class,
                //TipoNotificacionChart::class,
                //DevolucionDocumentosTable::class,
                //NotificacionesTabla::class,
                
                //Widgets\FilamentInfoWidget::class,
                //NotificacionesNoti::class,
                
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
            ]);
    }
}
