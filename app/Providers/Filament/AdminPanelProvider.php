<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Pages\Auth\EditProfile;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
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

                NavigationGroup::make()
                     ->label('Roles y Permisos')
                     ->collapsed('false'),
                
            ])
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
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
