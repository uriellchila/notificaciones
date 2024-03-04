<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentoNotificador;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Illuminate\Database\Query\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EstadisticaNotificadorOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $notificaciones=NotificacionDocumento::where('user_id',Auth::user()->id)->where('deleted_at',null)->count();
        $puesto=1;
        $temp=0;
        $totalnotificadores = DB::table('users')
           ->whereExists(function (Builder $query) {
               $query->select(DB::raw(1))
                     ->from('documentos')
                     ->whereColumn('documentos.user_id', 'users.id');
           })
           ->count();
        $notis = DB::table('users')
           ->whereExists(function (Builder $query) {
               $query->select(DB::raw(1))
                     ->from('documentos')
                     ->whereColumn('documentos.user_id', 'users.id');
           })
           ->get();
           //dd($notis);
        foreach($notis as $data ){
            $temp=NotificacionDocumento::where('user_id',$data->id)->where('deleted_at',null)->count();
            if($temp>$notificaciones){
                $puesto=$puesto+1;
            }
        }
        return [
             Stat::make('Ranking Notificaciones', $puesto.'°')
            ->description('de '.$totalnotificadores. ' notificadores..')
            ->descriptionIcon('heroicon-m-trophy')
            ->chart([0,1,2,3,$puesto])
            ->color('danger'),
            /*Stat::make('Total Conductores', Conductor::all()->count())
            ->description('Conductores Activos')
            ->descriptionIcon('heroicon-m-users')
            ->chart([7, 2, 10, 3, 15, 4, 50])
            ->color('warning'),*/
        ];
    }
}
