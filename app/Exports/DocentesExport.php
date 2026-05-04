<?php

namespace App\Exports; // <-- ESTE NAMESPACE ES CRÍTICO

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocentesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = User::role('docente');

        // Aplicar los mismos filtros que en el controlador
        if ($this->request->filled('search')) {
            $search = $this->request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('app_usu', 'like', '%' . $search . '%')
                  ->orWhere('apm_usu', 'like', '%' . $search . '%');
            });
        }

        if ($this->request->filled('status')) {
            $status = $this->request->input('status');
            $query->where('activo_usu', (bool)$status);
        }

        // Aplicar ordenamiento
        $sortBy = $this->request->input('sort_by', 'id');
        $sortDirection = $this->request->input('sort_direction', 'asc');
        $allowedSortColumns = ['id', 'name', 'app_usu', 'apm_usu', 'email', 'activo_usu'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }
        $query->orderBy($sortBy, $sortDirection);

        return $query->get(); // Retornar la colección de estudiantes filtrados
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Correo',
            'Estado',
        ];
    }

    /**
     * @param mixed $docente
     * @return array
     */
    public function map($docente): array
    {
        return [
            $docente->id,
            $docente->name,
            $docente->app_usu,
            $docente->apm_usu,
            $docente->email,
            $docente->activo_usu ? 'Activo' : 'Inactivo',
        ];
    }
}