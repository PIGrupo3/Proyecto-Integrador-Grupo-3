<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Collection;
use App\Persona;
use DB;

class PdfController extends Controller
{
    /*public function imprimirPersonas(Request $request){
        $request->user()->authorizeRoles(['admin','emple']);
        
        $personas = DB::table('persona')
        ->select('persona.num_documento','persona.nombre','persona.apellido','persona.email','persona.contacto')
        ->get();

        $pdf = \PDF::loadView('Pdf.personasPDF',[
            'personas' => $personas,
                ]);

        $pdf->setPaper('carta', 'A4');
        return $pdf->download('Listado De Personas.pdf');
    }

    public function imprimirClientes(Request $request){
        $request->user()->authorizeRoles(['admin','emple']);

        $clientes = DB::table('cliente as cli')
        ->join('persona as per', 'per.num_documento','=','cli.num_documento')
        ->select('cli.id_cliente','cli.num_documento','per.nombre','per.apellido')
        ->get();

        $pdf = \PDF::loadView('Pdf.clientesPDF',[
            'clientes' => $clientes
            ]);

            $pdf->setPaper('carta', 'A4');
            return $pdf->download('Listado De Cliente.pdf');
    }*/
    
    //REPORTE DE TODOS LOS VEHICULOS QUE ESTEN EN LA BD
    public function imprimirVehiculos(Request $request){
        $request->user()->authorizeRoles(['admin','operario']);

        $vehiculos = DB::table('vehiculos as ve')
        ->join('tipo_vehiculos as tv','tv.id_tipo','=','ve.tipo_vehiculos_id_tipo')
        ->select('tv.nombre','ve.tipo_vehiculos_id_tipo','ve.id_vehiculo','ve.placa')
        ->get();

        //dd($vehiculos);

        $pdf = \PDF::loadView('Pdf.vehiculosPDF',[
            'vehiculos' => $vehiculos
            ]);
            
            $pdf->setPaper('carta', 'A4');
            return $pdf->download('Listado De Vehiculos.pdf');
    }
    //REPORTE EN PDF DE LOS VEHICULOS EN ESPECIFICO QUE ESTEN EN LA BD, CON PARAMETROS (ID_VEHICULO)
    public function imprimirVehiculoEspecifico(Request $request,$id_vehiculo){
        $request->user()->authorizeRoles(['admin','operario']);

        $vehiculoespecifico = DB::table('vehiculoS as ve')
        ->join('tipo_vehiculos as tv','tv.id_tipo','=','ve.tipo_vehiculos_id_tipo')
        ->select('tv.nombre','ve.tipo_vehiculos_id_tipo','ve.id_vehiculo','ve.placa')
        ->where('ve.id_vehiculo','=',$id_vehiculo)
        ->get();

        foreach ($vehiculoespecifico as $ve) {
            $tiponombre=$ve->nombre;
            $tipovehiculoid=$ve->tipo_vehiculos_id_tipo;
            $idvehiculo=$ve->id_vehiculo;
            $placavehiculo=$ve->placa;
        }
        //dd($vehiculoespecifico);

        $pdf = \PDF::loadView('Pdf.vehiculoEspecificoPDF',[
            'tiponombre' => $tiponombre,
            'tipovehiculoid' => $tipovehiculoid,
            'idvehiculo' => $idvehiculo,
            'placavehiculo' => $placavehiculo,
            ]);
            
            $pdf->setPaper('carta', 'A4');
            return $pdf->download('Vehiculo Especifico.pdf');
    }
    //REPORTE DE TODOS LOS VEHICULOS QUE HAYAN INGRESO AL PARQUEADERO
    public function imprimirIngreso_vehiculos(Request $request)
    {
        $request->user()->authorizeRoles(['admin','operario']);
        $ingreso = DB::table('ingreso_vehiculos as i')
            ->join('vehiculos as ve', 've.Id_Vehiculo', '=', 'i.Vehiculos_Id_Vehiculo')
            ->join('tipo_vehiculos as tv', 'tv.Id_Tipo', '=', 've.tipo_vehiculos_id_tipo')
            ->join('users as u','u.id','=','i.users_id')
            ->select('ve.Id_Vehiculo', 've.Placa', 'i.Fecha_Ingreso', 'i.Estado', 'tv.Nombre', 'u.name')
            ->get();

        $pdf = \PDF::loadView('Pdf.ingreso_vehiculosPDF', [
            'ingreso' => $ingreso
            ]);
            
        $pdf->setPaper('carta', 'A4');

        return $pdf->download('Listado de Vehiculos.pdf');
    }
    //REPORTE PDF INGRESO DE VEHICULO EN ESPECIFICO, ENVIANDOLE PARAMETROS (ID_INGRESO)
    public function imprimirIngresoEspecifico(Request $request,$id_ingreso){
        $request->user()->authorizeRoles(['admin','operario']);

        $ingresoespecifico = DB::table('ingreso_vehiculos as iv')
        ->join('vehiculos as v','v.id_vehiculo','=','iv.vehiculos_id_vehiculo')
        ->join('tipo_vehiculos as tv','tv.id_tipo','=','v.tipo_vehiculos_id_tipo')
        ->join('users as u','u.id','=','iv.users_id')
        ->select('v.id_vehiculo', 'v.placa', 'iv.id_ingreso', 'iv.fecha_ingreso', 'iv.estado', 'tv.nombre', 'u.name')
        ->where('iv.id_ingreso','=',$id_ingreso)
        ->get();
        
        foreach ($ingresoespecifico as $in) {
            $idvehiculo=$in->id_vehiculo;
            $placavehiculo=$in->placa;
            $idingreso=$in->id_ingreso;
            $fechaingreso=$in->fecha_ingreso;
            $estadoin=$in->estado;
            $tipovehiculo=$in->nombre;
            $nombreusuario=$in->name;
        }

        $pdf = \PDF::loadView('Pdf.ingreso_vehiculosEspecificoPDF',[
            'idvehiculo' => $idvehiculo,
            'placavehiculo' => $placavehiculo,
            'fechaingreso' => $fechaingreso,
            'estado' => $estadoin,
            'idingreso' => $idingreso,
            'tipovehiculo' => $tipovehiculo,
            'nombreusuario' => $nombreusuario,
            ]);
            
            $pdf->setPaper('carta', 'A4');

            return $pdf->download('Ingreso Especifico.pdf');
    }
    //SALIDA ESPECIFICA //
    public function imprimirSalidaEspecifico(Request $request, $ingreso_vehiculos_id_ingreso)
    {
        $request->user()->authorizeRoles(['admin','operario']);
        $salidaespecifico = DB::table('salida_vehiculos as sv')
            ->join('ingreso_vehiculos as iv', 'iv.id_ingreso', '=', 'sv.ingreso_vehiculos_id_ingreso')
            ->join('vehiculos as v','v.id_vehiculo','=','iv.vehiculos_id_vehiculo')
            ->join('tipo_vehiculos as tv','tv.id_tipo','=','v.tipo_vehiculos_id_tipo')
            ->select('iv.id_ingreso', 'v.placa', 'iv.fecha_ingreso', 'sv.fecha_salida', 'tv.nombre', 'sv.total')    
            ->where('sv.ingreso_vehiculos_id_ingreso', '=', $ingreso_vehiculos_id_ingreso)
            ->get();
        //dd($salidaespecifico);

        foreach ($salidaespecifico as $s){
            $idingreso = $s->id_ingreso;
            $placavehiculo = $s->placa;
            $fechaingreso = $s->fecha_ingreso;
            $fechasalida = $s->fecha_salida;
            $tiponombre = $s->nombre;
            $valortotal = $s->total;
        }

        $pdf = \PDF::loadView('Pdf.salida_vehiculosEspecificoPDF', [
            'placavehiculo' => $placavehiculo,
            'fechaingreso' => $fechaingreso,
            'fechasalida' => $fechasalida,
            'idingreso' => $idingreso,
            'tiponombre' => $tiponombre,
            'valortotal' => $valortotal,

        ]);
        $pdf->setPaper('carta', 'A4');

        return $pdf->download('Salida Vehiculo Especifico.pdf');
      
    }
    public function imprimirVehiculosRetirados(Request $request)
    {

        $salida = DB::table('salida_vehiculos as s')
            ->join('ingreso_vehiculos as i', 'i.id_ingreso', '=', 's.ingreso_vehiculos_id_ingreso')
            ->join('vehiculos as v', 'v.id_vehiculo', '=', 'i.vehiculos_id_vehiculo')
            ->join('tipo_vehiculos as tv', 'tv.id_tipo', '=', 'v.tipo_vehiculos_id_tipo')
            ->orderBy('Id_Ingreso', 'desc')
            ->select('i.Id_Ingreso', 'v.Placa', 'i.Fecha_Ingreso', 's.Fecha_salida', 'tv.Nombre', 's.Total')->get();
        $pdf = \PDF::loadView('Pdf.vehiculos_retiradosPDF', ['salida' => $salida]);
        $pdf->setPaper('carta', 'A4');
        return $pdf->download('Listado de Vehiculos Retirados.pdf');
    }
}
