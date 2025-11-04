<?php

namespace Database\Seeders;

use App\Models\Parameters\Courses;
use App\Models\Parameters\Parameters;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //////////////////////////////////
        ///// Cursos e departamentos /////
        //////////////////////////////////

        $cursos_departamentos = [
            "INSTITUTO INTERDISCIPLINAR DE SOCIEDADE, CULTURA E ARTE",
            "COORDENADORIA DE GESTÃO DAS AÇÕES",
            "CENTRO DE CIÊNCIAS E TECNOLOGIA",
            "CENTRO DE CIÊNCIAS SOCIAIS APLICADAS",
            "FACULDADE DE MEDICINA",
            "CENTRO DE CIÊNCIAS AGRÁRIAS E DA BIODIVERSIDADE",
            "INSTITUTO DE FORMAÇÃO DE EDUCADORES",
            "PRÓ-REITORIA DE EXTENSÃO",
            "DIVISÃO DE GESTÃO PEDAGÓGICA",
            "DIVISÃO DE ADMISSIBILIDADE E SELEÇÃO",
            "PRÓ-REITORIA DE PLANEJAMENTO E ORÇAMENTO",
            "COORDENAÇÃO DO CURSO DE MEDICINA",
            "COORDENADORIA DE QUALIDADE DE VIDA NO TRABALHO",
            "DIVISÃO DE SAÚDE E NUTRIÇÃO",
            "DIVISÃO DE SERVIÇO SOCIAL E ARTICULAÇÃO ESTUDANTIL",
            "COORDENADORIA DE INTEGRAÇÃO, FORTALECIMENTO E ASSESSORAMENTO DAS AÇÕES DE EXTENSÃO",
            "NÚCLEO DE GESTÃO",
            "DIRETORIA DO SISTEMA DE BIBLIOTECAS",
            "DIVISÃO DE SISTEMAS DE INFORMAÇÃO EDUCACIONAIS",
        ];

        foreach ($cursos_departamentos as $item) {
            Courses::create([
                "name" => strtoupper($item),
                "status" => true
            ]);
        }

        //////////////////////
        ///// Parâmetros /////
        //////////////////////

        $parametros = [
            "MODALIDADE" => [
                "AÇÃO DE FLUXO CONTÍNUO",
                "VINCULADA A EDITAL",
                "UFCA ITINERANTE",
                "PROPE",
                "AMPLA CONCORRÊNCIA",
            ],
            "ÁREA TEMÁTICA" => [
                "COMUNICAÇÃO",
                "EDUCAÇÃO",
                "TECNOLOGIA E PRODUÇÃO",
                "SAÚDE",
                "TRABALHO",
                "CULTURA",
                "MEIO AMBIENTE",
                "DIREITOS HUMANOS E JUSTIÇA",
            ],
            "TIPO" => [
                "PRESTAÇÃO DE SERVIÇOS",
                "EVENTO",
                "CURSO",
                "PROJETO",
                "PROGRAMA",
            ],
            "PERFIL" => [
                "Coordenador",
                "Administrador"
            ]
        ];

        foreach($parametros as $key => $parametro){
            foreach($parametro as $item){
                Parameters::create([
                    "function" => $key, 
                    "value" => $item 
                ]);
            }
        }
    }
}
