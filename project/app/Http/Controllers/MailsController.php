<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Mail\Message;
use Mail;
use App\Models\Egresado;

class MailsController extends Controller
{

    // private $email_uibb = 'info@primer-trabajo.com.ar';
    private $email_uibb = 'mesarseuibb@gmail.com';

    public function contacto(Request $request) {

        $view_data = $request->all();
        $email = $view_data['email'];
        $nombre = $view_data['nombre'];

        Mail::send('emails.contacto', $view_data, function($message) use ($email,$nombre)
        {
            /** @var Message $message */
            $message->to($this->email_uibb, 'UIBB - Primer trabajo')
                ->replyTo($email, $nombre)
                ->subject('UIBB Primer trabajo - Formulario de contacto');
        });

        return redirect('/');
    }

    /** NO USADO */
    /*
    public function solicitarAcceso(Request $request,$tipo) {
        if ($tipo != 'empresa' && $tipo != 'institucion') {
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
                'tipo' => 'institucion',
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

    /**
     * Solicitud de datos de un egresado:
     *  Se envía mail a la dirección que requiere y dos copias:
     *      al mail de la UIBB y a la institución educativa
     *
     * Route: egresado_solicitar - /solicitar-datos-egresado/{id} [POST]
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function solicitarDatosEgresado(Request $request, $id) {
        $data = $request->all();

        $email = $data['email'];
        $nombre = $data['nombre'];
        $empresa = $data['empresa'];
        $egresado = null;

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
            $egresado = Egresado::find($id);
        }
        if (!$egresado || $egresado->privado) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Se solicitaron datos de egresado inválido.'
            ]);
        }

        // envío mail al solicitante
        $view_data = ['egresado' => $egresado];
        try {

            Mail::send('emails.solicitud_datos_egresado', $view_data, function($message) use($email,$nombre)
            {
                /** @var Message $message */
                $message->to($email, $nombre)->subject('UIBB Primer trabajo - Datos del egresado solicitado');
            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'mensaje' =>'No se pudo enviar el email.']);
        }

        // envío copias: a la UIBB y al docente responsable asociado al egresado
        $view_data = ['egresado' => $egresado, 'nombre' => $nombre, 'empresa' => $empresa, 'email' =>$email];
        Mail::send('emails.copia_solicitud_datos_egresado', $view_data, function($message)
        {
            /** @var Message $message */
            $message->to($this->email_uibb, 'UIBB - Primer trabajo')->subject('UIBB Primer trabajo - Solicitud de datos de egresado');
        });
        $docente = $egresado->docente;
        Mail::send('emails.copia_solicitud_datos_egresado', $view_data, function($message) use($docente)
        {
            /** @var Message $message */
            $message->to($docente->email, $docente->name)->subject('UIBB Primer trabajo - Solicitud de datos de egresado');
        });

        return response()->json(['status' => 'ok']);
    }
}
