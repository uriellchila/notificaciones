<?php

namespace App\Filament\Resources\DocumentoResource\Widgets;

use App\Models\Documento;
use Illuminate\Support\Facades\DB;
use App\Models\DevolucionDocumento;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificacionDocumento;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class NotificacionDocumentosOverview extends BaseWidget
{
    protected function getStats(): array
    {
       /* $notis_user=DocumentoNotificador::where('user_id',Auth::user()->id)->count();
        $puesto=1;
        $temp=0;
        $notis=User::query()->get();
        foreach($notis as $data ){
            $temp=DocumentoNotificador::where('user_id',$data->id)->count();
            if($temp>$notis_user){
                $puesto=$puesto+1;
            }
        }
*/
        
        return [
            Stat::make('Documentos Pendientes', Documento::query()->where('user_id',Auth::user()->id)->whereNotExists(function($query){$query->select(DB::raw(1))
                ->from('notificacion_documentos as nd')
                ->whereRaw('documentos.id = nd.documento_id')
                ->whereRaw('nd.deleted_at is null');
                    })
                ->whereNotExists(function($query){$query->select(DB::raw(1))
                    ->from('devolucion_documentos as dd')
                    ->whereRaw('documentos.id = dd.documento_id')
                    ->whereRaw('dd.deleted_at is null');
                    //->whereRaw('dd.deleted_at != null');
            })->count())
            ->description('De '. Documento::query()->where('user_id',Auth::user()->id)->count(). ' asignados')
            ->descriptionIcon('heroicon-m-document-check' )
            ->chart([0,2,5,7,10])
            ->color('success'),
            Stat::make('Documentos Notificados', NotificacionDocumento::where('user_id',Auth::user()->id)->where('deleted_at',null)->count())
            ->description('De '. Documento::query()->where('user_id',Auth::user()->id)->count(). ' asignados')
            ->descriptionIcon('heroicon-m-document-check')
            ->chart([0,2,5,7,8])
            ->color('info'),
            Stat::make('Documentos Devueltos', DevolucionDocumento::where('user_id',Auth::user()->id)->where('deleted_at',null)->count())
            ->description('De '. Documento::query()->where('user_id',Auth::user()->id)->count(). ' asignados')
            ->descriptionIcon('heroicon-m-document-check')
            ->chart([10,0,0,0])
            ->color('warning'),
           /* Stat::make('Ranking Notificaciones', $puesto.'°')
            ->description('de '.User::all()->count(). ' notificadores..')
            ->descriptionIcon('heroicon-m-trophy')
            ->chart([10,0,0,0,$puesto])
            ->color('warning'),*/
            /*Stat::make('Total Conductores', Conductor::all()->count())
            ->description('Conductores Activos')
            ->descriptionIcon('heroicon-m-users')
            ->chart([7, 2, 10, 3, 15, 4, 50])
            ->color('warning'),*/
        ];
    }
}
