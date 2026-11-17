<?php
namespace App\Http\Controllers;
// ver txt
use Illuminate\Http\Request;
class UtilController extends Controller
{
    public function loadWelcome() {
     return view('welcome');
    }

    public function loadHomepage () {
            //Dados que no futuro estarão definidos no controller e vêm da base de dados
    $courseName = 'SD';
    $userName = 'Andre';
    // simulo que vou à base de dados e trago a lista de alunos
    $students = ['Licínia', 'Raquel', 'João', 'Leonel'];
    //array associativo
        //dados que serão carregados da base de dados
        $contactInfo = [
            'name' => 'Bruno',
            'contact' => 'Bruno@cesae.pt'
        ];
            // ver txt
           // dd($contactInfo); e var_dump($contactInfo);
           $cesae_info = [
            'name' => 'Cesae',
            'address' => 'R. de Silva Tapada 115 4200-501 Porto',
            'email' => 'cesae@gmail.com'
        ];
    return view('home', compact('courseName', 'students', 'contactInfo', 'cesae_info'));
    }


}
