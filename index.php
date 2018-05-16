<?php
set_time_limit(3000);
require_once "vendor/autoload.php";
use App\Excel\ProccessData;
use Illuminate\Database\Capsule\Manager;

define("DS", DIRECTORY_SEPARATOR);
define("DOCUMENTS",  dirname(__FILE__) . DS . "documents" . DS);

$capsule = new Manager;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '195.190.82.247',
    'database' => 'gestion_arroba',
    'username' => 'arrobamedellin',
    'password' => 'vex3SP83xLeGQFNZ',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$processData = new ProccessData;
//$processData->generateDataCertificate(PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx'), 'cursos.xlsx')->saveCertificate();
$processData->generateDataStudent(PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx'), 'estudiantes.xlsx')->saveStudent();