<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Widgets;

use App\Models\User;
use App\Models\DocumentoNotificador;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Notificaciones extends BaseWidget
{
    protected function getStats(): array
    {
        $notis_user=DocumentoNotificador::where('user_id',Auth::user()->id)->count();
        $puesto=1;
        $temp=0;
        $notis=User::query()->get();
        foreach($notis as $data ){
            $temp=DocumentoNotificador::where('user_id',$data->id)->count();
            if($temp>$notis_user){
                $puesto=$puesto+1;
            }
        }
        
        return [
            Stat::make('Notificaciones', DocumentoNotificador::where('user_id',Auth::user()->id)->count())
            ->description('Total notificaciones registradas')
            ->descriptionIcon('heroicon-m-document-check')
            ->chart([0,2,5,7,10])
            ->color('success'),
            Stat::make('Notificaciones Hoy', DocumentoNotificador::where('fecha_notificacion',date('Y-m-d'))->where('user_id',Auth::user()->id)->count())
            ->description('Documentos notificados hoy')
            ->descriptionIcon('heroicon-m-document-check')
            ->chart([0,2,5,7,8])
            ->color('info'),
            Stat::make('Ranking Notificaciones', $puesto.'°')
            ->description('de '.User::all()->count(). ' notificadores..')
            ->descriptionIcon('heroicon-m-trophy')
            ->chart([10,0,0,0,$puesto])
            ->color('warning'),
            /*Stat::make('Total Conductores', Conductor::all()->count())
            ->description('Conductores Activos')
            ->descriptionIcon('heroicon-m-users')
            ->chart([7, 2, 10, 3, 15, 4, 50])
            ->color('warning'),*/
        ];
    }

}
