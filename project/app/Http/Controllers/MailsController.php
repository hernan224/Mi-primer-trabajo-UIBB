<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class MailsController extends Controller
{

    public function contacto(Request $request) {

        $view_data = $request->all();

        Mail::send('emails.contacto', $view_data, function($message)
        {
            $message->to('info@primer-trabajo.com.ar', 'Primer trabajo')->subject('Formulario de contacto');
        });

        return redirect('/');
    }

    /** NO USADO */
    /*
    public function solicitarAcceso(Request $request,$tipo) {
        if ($tipo != 'empresa' && $tipo != 'escuela') {
            return response('No autorizado', 403);
        }

        if ($tipo == 'empresa') {
            $view_data = [
                'tipo' => 'empresa',
                'razon_social' => $request->input('nombre'),
                'cuit' => $request->input('cuit'),
                'email' => $request->input('email')
            ];
        }
        else {
            $view_data = [
                'tipo' => 'escuela',
                'nombre' => $request->input('nombre'),
                'docente' => $request->input('docente'),
                'email' => $request->input('email')
            ];
        }

        Mail::send('emails.solicitud_acceso', $view_data, function($message)
        {
            $message->to('info@primer-trabajo.com.ar', 'Primer trabajo')->subject('Solicitud de acceso');
        });

        return redirect('/');
    }
    */

    // public function ayuda() {

    // }
}
