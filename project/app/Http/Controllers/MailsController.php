<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use App\Models\Alumno;

class MailsController extends Controller
{

    private $email_uibb = 'info@primer-trabajo.com.ar';

    public function contacto(Request $request) {

        $view_data = $request->all();

        Mail::send('emails.contacto', $view_data, function($message)
        {
            $message->to($this->email_uibb, 'Primer trabajo')->subject('Formulario de contacto');
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

    public function solicitarDatosAlumno(Request $request, $id) {
        $data = $request->all();

        $email = $data['email'];
        $nombre = $data['nombre'];
        $empresa = $data['empresa'];
        $alumno = null;

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El email ingresado es inválido.'
            ]);
        }
        if (!$nombre) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'No indicó nombre y apellido.'
            ]);
        }

        if ($id) {
            $alumno = Alumno::find($id);
        }
        if (!$alumno || $alumno->privado) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Se solicitaron datos de alumno inválido.'
            ]);
        }

        // envío mail al solicitante
        $view_data = ['alumno' => $alumno];
        try {
            Mail::send('emails.solicitud_datos_alumno', $view_data, function($message) use($email,$nombre)
            {
                $message->to($email, $nombre)->subject('Datos del alumno solicitado');
            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'mensaje' =>'No se pudo enviar el email.']);
        }

        // envío copia
        $view_data = ['alumno' => $alumno, 'nombre' => $nombre, 'empresa' => $empresa, 'email' =>$email];
        Mail::send('emails.copia_solicitud_datos_alumno', $view_data, function($message) use($email,$nombre)
        {
            $message->to($this->email_uibb, $nombre)->subject('Solicitud de datos de alumno');
        });

        return response()->json(['status' => 'ok']);
    }
}
