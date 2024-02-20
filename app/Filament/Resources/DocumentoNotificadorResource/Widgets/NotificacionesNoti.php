<?php

namespace App\Filament\Resources\DocumentoNotificadorResource\Widgets;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentoNotificador;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class NotificacionesNoti extends BaseWidget
{
    protected function getStats(): array
    {
        /*$notis=User::query()->get();
        foreach($notis as $data ){
        return [
            
                Stat::make($data->name, DocumentoNotificador::where('user_id',$data->id)->count())
                ->description('Total notificaciones registradas')
                ->descriptionIcon('heroicon-m-document-check')
                ->chart([0,DocumentoNotificador::where('user_id',$data->id)->count()])
                ->color('success'),
                    
        ];*/
        $notis='';
        $notis=User::query()->get();
        $consulta = DB::table('users')
        ->select('id','name')
        ->get();
         $hola=[];
         $hola=implode(', ', array_column($notis->toArray(), 'name'));
        dd($hola);
        //return $string_from_array;
        
        
    
    }
    
}
