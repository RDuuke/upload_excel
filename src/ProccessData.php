<?php
namespace App\Excel;

use App\Excel\Models\Certicifate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Excel\Models\Student_Certificate;
use App\Excel\Models\Student;


class ProccessData
{
    protected $nameFile;

    protected $dataCertificate = array();
    protected $dataStudent = array();

    function generateDataCertificate($reader, String $file)
    {
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(DOCUMENTS . $file);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        for ($row=2; $row <= $highestRow; $row++) {
            $data = [
                "tipo" => trim($worksheet->getCell('A'. $row)->getvalue()),
                "template" => trim($worksheet->getCell('B'. $row)->getvalue()),
                "codigo" => trim($worksheet->getCell('C'. $row)->getvalue()),
                "titulo" => trim($worksheet->getCell('D'. $row)->getvalue()),
                "contenido" => trim($worksheet->getCell('E'. $row)->getvalue()),
                "duracion" => trim($worksheet->getCell('F'. $row)->getvalue()),
                "fecha_finalizacion" => trim($worksheet->getCell('G'. $row))
            ];

            array_push($this->dataCertificate, $data);
            $data = null;
        }
        return $this;
    }

    function saveCertificate()
    {
        for($i=0; $i<count($this->dataCertificate); $i++) {
            Certicifate::create($this->dataCertificate[$i]);
        }
        unset($this->dataCertificate);
        return true;
    }

    function generateDataStudent($reader, $file)
    {
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(DOCUMENTS . $file);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        for ($row=2; $row <= $highestRow; $row++) {
            $data = [
                "usuario" => trim($worksheet->getCell('A'. $row)->getvalue()),
                "clave" => trim($worksheet->getCell('B'. $row)->getvalue()),
                "nombres" => trim($worksheet->getCell('C'. $row)->getvalue()),
                "apellidos" => trim($worksheet->getCell('D'. $row)->getvalue()),
                "correo" => trim($worksheet->getCell('A'. $row)->getvalue()),
                "documento" => trim($worksheet->getCell('E'. $row)->getvalue()),
                "institucion" => trim($worksheet->getCell('F'. $row)->getvalue()),
                "genero" => trim($worksheet->getCell('G'. $row)->getvalue()),
                "ciudad" => trim($worksheet->getCell('H'. $row)->getvalue()),
                "departamento" => trim($worksheet->getCell('I'. $row)->getvalue()),
                "pais" => trim($worksheet->getCell('J'. $row)->getvalue()),
                "telefono" => trim($worksheet->getCell('K'. $row)->getvalue()),
                "celular" => trim($worksheet->getCell('L'. $row)->getvalue()),
                "direccion" => trim($worksheet->getCell('M'. $row)->getvalue()),
                "curso" => trim($worksheet->getCell('N'. $row)->getvalue())
            ];

            array_push($this->dataStudent, $data);
            $data = null;
        }
       // print_r($this->dataStudent);
        return $this;
    }

    function saveStudent()
    {
        for($i=0; $i<count($this->dataStudent); $i++) {
            $student = Student::updateOrCreate(['usuario' => $this->dataStudent[$i]['usuario']],$this->dataStudent[$i]);
            $course = Certicifate::select('id')->where("codigo", "=", $this->dataStudent[$i]['curso'])->first();
            Student_Certificate::create(['certificado_id' => $course->id, 'usuario_id' => $student->usuario, "estado" => 0]);
            if(($i % 20 && $i > 19) == 0) {
                echo "bloque realizado" .  PHP_EOL;
                sleep(1);
            }
            echo "usuario : " . $this->dataStudent[$i]['usuario'] . " creado y agregado a tabla de certificado con id:certificado: ". $course->id .  PHP_EOL;
        }
        return true;
    }

}