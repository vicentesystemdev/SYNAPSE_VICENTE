<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoPageController extends Controller
{
    public function webInfo()
    {
        return view('web-info');
    }

    public function cryptoInfo()
    {
        return view('crypto-info');
    }

    public function stegoInfo()
    {
        return view('stego-info');
    }

    public function forensInfo()
    {
        return view('forens-info');
    }

    public function documentacionInfo()
    {
        return view('estudiante.informacion.documentacion');
    }

    public function manualEstudianteInfo()
    {
        return view('estudiante.informacion.manual_estudiante');
    }

    public function manualDocenteInfo()
    {
        return view('estudiante.informacion.manual_docente');
    }

    public function politicasEvaluacionInfo()
    {
        return view('estudiante.informacion.politicas_evaluacion');
    }

    public function preguntasFrecuentesInfo()
    {
        return view('estudiante.informacion.preguntas_frecuentes');
    }

    public function sobreProyectoInfo()
    {
        return view('estudiante.informacion.sobre_proyecto');
    }

    public function propositoAcademicoInfo()
    {
        return view('estudiante.informacion.proposito_academico');
    }

    public function modeloEvaluacionAdaptativaInfo()
    {
        return view('estudiante.informacion.modelo_evaluacion_adaptativa');
    }

    public function metodologiaReferenciasInfo()
    {
        return view('estudiante.informacion.metodologia_referencias');
    }
}
