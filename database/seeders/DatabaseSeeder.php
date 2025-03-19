<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'status' => 1,
        ]);

        $permissions = [
            "1" => "adicionar_grupo",
            "2" => "adicionar_usuário",
            "3" => "ver_dashboard",
            "4" => "adicionar_cursos",
            "5" => "adicionar_projetos",
            "6" => "responder_formulário",
            "7" => "adicionar_formulário",
            "8" => "ver_respostas",
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $role = Role::create([
            'name' => 'Gerente',
            'guard_name' => 'web'
        ]);

        
        $role->givePermissionTo([
            "adicionar_grupo",
            "adicionar_usuário",
            "ver_dashboard",
            "adicionar_cursos",
            "adicionar_projetos",
            "responder_formulário",
            "ver_respostas",
            "adicionar_formulário",
        ]);

        $role2 = Role::create([
            'name' => 'Professor',
            'guard_name' => 'web'
        ]);

        $role2->givePermissionTo([
            "responder_formulário",
        ]);

        $user->assignRole($role);

        $courses = [
            "Administração",
            "Administração Pública e Gestão Social",
            "Biblioteconomia",
            "Ciências Contábeis",
            "Ciência da Computação",
            "Engenharia Civil",
            "Engenharia de Materiais",
            "Matemática Computacional",
            "Design",
            "Filosofia (Bacharelado)",
            "Filosofia (Licenciatura)",
            "Jornalismo",
            "Letras / Libras",
            "Música",
            "Agronomia",
            "Medicina Veterinária",
            "Licenciatura Interdisciplinar em Ciências Naturais e Matemática",
            "Pedagogia",
            "Física",
            "Química",
            "Biologia",
            "Matemática",
            "Medicina",
        ];
        $projects = [
            "LIGA ACADÊMICA DE MEDICINA BASEADA EM EVIDÊNCIAS (LAMEB)",
            "QUAL O PESO DO LIXO? Valorizando a dignidade dos recicladores a partir de uma visão universitária",
            "Plantas nativas: o seu lugar é também na cidade",
            "LIGA ACADÊMICA DE MEDICINA INTERNA DO CARIRI - LAMICA",
            "Liga de Saúde Comunitária do Cariri (LISAC)",
            "Atividades lúdicas: um remédio sinérgico para o tratamento coadjuvante de crianças hospitalizadas na Região do Cariri – Projeto Feliz",
            "Laboratório Vivo de Agricultura Urbana (LVAUP)– um novo desafio para o NUPEH/CCAB/UFCA",
            "LIGA ACADÊMICA DE PSIQUIATRIA DA UFCA: PROMOÇÃO DE SAÚDE MENTAL E PREVENÇÃO DO SUICÍDIO DE JOVENS NA REGIÃO DO CARIRI",
            "LIAC - LIGA DE IMUNOPATOLOGIA E ALERGIAS DO CARIRI",
            "CUIDADOS COM A SAÚDE NA TERCEIRA IDADE",
            "Embaixadores da Ciência e Engenharia de Materiais",
            "Liga Universitária de Neurociências - LUNEC",
            "Liga Acadêmica de Microbiologia Médica – LAMIC",
            "Projeto: Promovendo a saúde emocional através da meditação (21 Dias)",
            "Liga Acadêmica de Medicina Esportiva e Nutrologia – LAMEN",
            "Estação meteorológica do Cariri",
            "INTEGRANDO AÇÕES EM MATEMÁTICA",
            "Corte Seco - revista de audiovisual",
            "Entre a esperança e a obrigação: um projeto de apoio para doentes renais crônicos na região do Cariri.",
            "Divulgando a Física com Experimentos de Baixo Custo",
            "Estilo de Vida Saudável na Escola",
            "Liga de Infectologia do Cariri - LINFEC",
            "ÁLCOOL: INFORMAR PARA CONSCIENTIZAR E PREVENIR",
            "Oficina Educativa Ambiental",
            "Observatório de Políticas Públicas Indígenas e Indigenistas",
            "Liga Acadêmica Caririense de Endocrinologia e Metabologia (LACEM)",
            "Projeto Prevenção de Doenças Cardiovasculares",
            "LIGA ACADEMICA DE HEMATOLOGIA E HEMOTERAPIA DO CARIRI (LAHEC)",
            "Programa Caririense de Emergência e Trauma- PCET",
            "Sementes do Amanhã: promovendo a inclusão e educação ambiental",
            "COLETAR, EDUCAR e TANSFORMAR",
            "Observando o céu do Cariri: Divulgação científica através da astronomia",
            "Instalação de capineiras em propriedades de pequenos agricultores da região do Cariri no Ceará",
            "Liga Acadêmica de Pneumologia",
            "LIXO DE FÁRMACOS: Impactos do descarte incorreto de medicamentos na saúde do homem e do meio ambiente",
            "Liga Acadêmica de Saúde e Sexualidade do Cariri (LASSC)",
            "Primeiros Socorros nas Escolas: Formando Cidadãos Ativos na Promoção de Saúde",
            "NAGES - NÚCLEO DE APOIO À GESTÃO EM ENTIDADES SOCIAIS",
            "FORMAÇÃO BÁSICA DE PROFISSIONAIS PARA ATIVIDADES DA CONSTRUÇÃO CIVIL",
            "CONSULTORIA PARA PEQUENOS EMPREENDIMENTOS: INTEGRAÇÃO ENTRE AGENTES DO ECOSSISTEMA EMPREENDEDOR.",
            "Cinema Socioambiental no Cariri",
            "Liga Multidisciplinar em Diabetes mellitus - LIMUD",
            "Projeto de Educação Financeira e Empreendedorismo em Medicina - PEFEM",
            "Prática Educativa na Biblioteca Escolar: aplicação das Leis de Ranganathan para dinamizar o uso do acervo da Escola de tempo integral Josefa Alves de Sousa",
            "LIGA DE CIRURGIA DO CARIRI: LICIC",
            "Liga Acadêmica de Fisiologia Médica - LAFMED",
            "Liga Acadêmica de Clínica Médica (LACM)",
            "Engenharia acolhedora: Uma experiência para além do acesso",
            "LADEC - LIGA ACADÊMICA DE DOENÇAS ESTIGMATIZANTES DO CARIRI",
            "Filo Sofia - construção de saberes filosoficos",
            "SAÚDE E LIXO: desenvolvendo reciclagem e consciência ambiental no município de Barbalha",
            "Liga de Farmacologia do Cariri – LIFAC",
            "LIGA ACADÊMICA DE TOXICOLOGIA DO CARIRI",
            "ATENÇÃO AO TRAUMA ORTOPÉDICO",
            "COMPREENDENDO A EDUCAÇÃO FISCAL PARA EXERCÍCIO DA CIDADANIA.",
            "Liga de Pediatria Caririense",
            "AGROTEMPO - Agrometeorologia para Agricultores do Cariri",
            "MC²: Mulheres Cientistas no Cariri",
            "LIGA ACADEMICA DE ATENDIMENTO MOVEL DE URGÊNCIA ( LAAMU )",
            "MEMÓRIAS KARIRI",
            "Conecte-se: plataforma digital de conexão entre profissionais",
            "Ressignificando práticas alimentares: o papel da nutrição no controle da Diabetes Mellitus.",
            "LIGA ACADÊMICA DE CARDIOLOGIA DO CARIRI - LICARDIO",
            "TUTORIA DE ESTUDOS EM PRÉ-VESTIBULAR COMUNITÁRIO",
            "Música na Escola Pública",
            "Núcleo de Arqueologia e Paleontologia do Cariri (NAP)",
            "Saboaria medicinal e sustentável",
            "Liga Acadêmica de Semiologia Médica (LIASEM)",
            "USO DE DIPIRONA EM GESTANTES E AÇÃO NO CANAL ARTERIAL DE FETOS SAUDÁVEIS",
            "LIGA ACADÊMICA DE HISTOLOGIA E PATOLOGIA ANIMAL (LAHPATO)",
            "Escritório Habitar",
            "Liga Acadêmica de Hematologia e Hemoterapia do Cariri",
            "Programa de Atenção à Gestante - Progest",
            "Liga de Saúde Mental- LISAM",
            "Programa de Extensão em Dor e Cuidados Paliativos na Rede de Atenção à Saúde no Cariri",
            "Liga Acadêmica de Nefrologia - LINEFRO",
            "Pensamento Computacional",
            "Pela tela, pela janela: Contribuições para compreensão e registro de desafios e potencialidades do cotidiano escolar para residentes em contextos rurais de Barbalha-CE",
            "Laboratório Interdisciplinar de Estudos em Gestão Social- LIEGS",
            "PROGRAMA DE APOIO À PESSOA COM DEFICIÊNCIA (PRAPED)",
            "Observatório das Cidades do Cariri",
            "FeNat: explorando a natureza da química através dos fenômenos naturais",
            "Premium Consultoria Júnior",
            "VALORIZANDO VIDAS",
            "EDIFIQUE AÇÕES",
            "Mulheres.h",
            "Melhoria nos sistemas produtivos da Agricultura Familiar por meio de unidades demonstrativas de culturas agrícolas importantes para a região",
            "Grupo de Estudos em Reprodução Animal da UFCA (GERA-UFCA)",
            "Programa de Atenção Integral à Saúde da Mulher (ProCASM)",
            "Núcleo em Gestão de Pessoas (NUGEP)",
            "LOGUS: Cursinho Pré-Vestibular Comunitário do Cariri",
            "Núcleo de Apoio Contábil e Fiscal - NAF",
            "Liga Universitária de Patologia do Cariri - LUPAC",
            "Laboratório de Estudos em Violência e Segurança Pública",
            "FORMANDO CIENTISTAS",
            "Enactus UFCA",
            "Ações de sustentabilidade ambiental em escolas de ensino básico da rede pública em Juazeiro do Norte - Ce: uma proposta para a gestão integrada de resíduos sólidos urbanos",
            "Cariri Consciente: O conhecimento transforma o cidadão",
            "LABIM - LIGA ACADÊMICA DE BUILDING INFORMATION MODELLING",
            "​​Consultoria Solidária - CONSOL​",
            "Grupo de desenvolvimento rural sustentável -GDRS",
            "Programa de educação ambiental, saúde e bem-estar animal.",
            "LAMAC - LABORATÓRIO DE ENSINO, PESQUISA, EXTENSÃO E CULTURA EM MATERIAIS DE CONSTRUÇÃO",
            "LIGA ACADÊMICA DE NEUROCIRURGIA E NEUROLOGIA DO CARIRI",
            "Liga Caririense de Medicina Integrativa - LICAMI",
            "Escrita e leitura: Caminhos para Formação Sócio- Cultural de Crianças e Adolescentes no Orfanato Jesus Maria e José, Juazeiro do Norte- CE",
            "ACESSOEDU: Acesso à educação superior no Brasil",
            "PhyPlant",
            "Maria Bonita",
            "Projeto de Apoio às Crianças com Cardiopatias Congênitas (PROACCC)",
            "Vozes silenciadas: Registro da Memória de Comunidades Quilombolas do Cariri.",
            "Podcast Depois dos Créditos",
            "MULHERES PENSANTES: A CONSTRUÇÃO DO CONHECIMENTO E A OCUPAÇÃO DOS ESPAÇOS PÚBLICOS",
            "PROPOSTA DE GRUPO DE LEITURA DA OBRA DE FIÓDOR DOSTOIÉVSKI",
            "Liga Acadêmica de Neonatologia (LANEO)",
            "Transformare",
            "POLINIZE",
            "CÍRCULOS DE LEITURA: EDUCAÇÃO FILOSÓFICA EM COMUNIDADE",
            "Projeto de Atenção Integral à Saúde Sexual e Reprodutiva dos Adolescentes (PAISS)",
            "Tenho Urgência",
            "EDUCAR COM EDUCAÇÃO AMBIENTAL",
            "MUSEU- ESCOLA ITINERANTE DE ANATOMIA ANIMAL",
            "Clube de Cinema da UFCA Clube da Zueira",
            "Guia de Mercado PET",
            "Projeto de Atenção Integral à Saúde da Gestante no Pré-Natal (ProISGesP)",
            "LIGA ACADÊMICA DE MEDICINA FELINA DA UFCA - LIAMEF UFCA",
            "UFCA ITINERANTE",
            "LIGA ACADÊMICA DE BUILDING INFORMATION MODELING",
            "LIGA ACADÊMICA DE GEOTECNIA -UFCA",
            "MC²: Mulheres Cientistas no Cariri",
            "GESTÃO FINANCEIRA ESCOLAR: CAPACITANDO GESTORES ESCOLARES DO MUNICÍPIO DE CAUCAIA E MICRORREGIÃO, PARA TRANSPARÊNCIA E EFETIVIDADE DOS RECURSOS PÚBLICOS",
            "Conhecimento, Planejamento e Sustentabilidade voltados a Produção Agroindustrial",
            "Cursos de Capacitação para Produção de tijolos de solo-cimento com adição de resíduos",
            "FORMAÇÃO BÁSICA DE PROFISSIONAIS PARA CONSTRUÇÃO CIVIL",
            "Startup: Conecte-se!",
            "Power BI (Módulo I)",
            "Trigonometria: do Ensino Médio ao Ensino Superior",
            "Liga acadêmica de Engenharia de Materiais-(LAEM)",
            "1° ECEF - Encontro Cearense de Estudantes de Filosofia",
            "ESTUDOS SURDOS EM EDUCAÇÃO",
            "I Semana da Computação",
            "LABORATÓRIO DE MATERIAIS DE CONSTRUÇÃO E SUSTENTABILDADE",
            "LANÇAMENTO DA SEMANA DA ENGENHARIA CIVIL NO CARIRI",
            "Famílias Fortes: Fortalecendo famílias através do acompanhamento psicossocial",
            "II Semana de Letras-Libras da UFCA",
            "Minicurso Literatura em Libras: abordagem didática e educacional",
            "Minicurso: O contexto tecnológico dos recursos de comunicação utilizados por",
            " sinalizantes na atualidade",
            "Minicurso: A formação dos sinais com base nas tendências das mudanças linguísticas",
            "Minicurso: Estratégias de ensino e de aprendizagem da Libras através de dinâmicas e materiais não convencionais",
            "Oficina: As metáforas da Libras",
            "Minicurso Noções Básicas de SignWriting",
            "Minicurso: A língua de sinais como suporte da memória coletiva da comunidade surda",
            "Minicurso - Surdocegueira: relatos de experiência como guia-intérprete",
            "XI Semana Acadêmica de Biblioteconomia e Ciência da Informação (SEABI)",
            "TEORIA CRÍTICA, SOCIEDADE E EDUCAÇÃO",
            "Projetos de interiores para o coletivo da “Quebrada cultural”",
            "Fórum de estágio curricular reflexões para o ensino de Libras como L1 e L2",
            "II Semana da Pedagogia: Inclusão educacional: desafios da prática docente",
            "Projeto Aulas Abertas: Aula Aberta com jornalista Francisco José sob o tema “Ser Jornalista: desafios da profissão”",
            "Recital de Canto Coral: arranjos, composições e música popular",
            "CURSO SOBRE PRÁTICA DE FABRICAÇÃO DE BLOCO ECOLÓGICO",
            "PROJETO SEMEAÇÃO DE DIVULGAÇÃO CIENTÍFICA",
            "Lançamento de livro: Inventário dos seus abraços",
            "Power BI (Módulo II)",
            "Power BI (Módulo I)",
            "ENCONTROS DE ENGENHARIA CIVIL NO CARIRI",
            "PROMOVENDO A INTEGRAÇÃO ENTRE GERAÇÕES NA COMUNIDADE BARAÚBAS",
            "PROBEA – Programa de bem-estar animal",
            "PROGRAMA DE EDUCAÇÃO TUTORIAL DO CURSO DE ADMINISTRAÇÃO-PETADM",
            "GEAS UFCA - Grupo de Estudos de Animais Silvestres da Universidade Federal do Cariri",
            "Explorando Questões Ecológicas no Antropoceno",
            "III Encontro Cearense de Professores de Filosofia",
            "Entre a ciência e a cultura popular: Investigando os efeitos do sal de cozinha nas panelas de barro",
            "Libras para atendimento ao público",
            "27ª EDIÇÃO DO ANDANÇAS CULTURAIS",
            "II ENCONTRO DO PIBID DA UNIVERSIDADE FEDERAL DO CARIRI (II ENPIBID/UFCA) I ENCONTRO DA RESIDÊNCIA PEDAGÓGICA DA UFCA (I ERP)",
            "IV SEMANA DO MÉDICO VETERINÁRIO: Especialidades em Medicina Veterinária",
            "VI Encontro de Biologia do IFE/UFCA: Explorando as fronteiras da vida: de moléculas a ecossistemas",
            "IV SEMINÁRIO INOVAÇÃO NA ENGENHARIA CIVIL",
            "VIII Semana de Engenharia Civil da UFCA",
            "Movimento Freireano",
            "Eclipse Solar no Cariri 2023",
            "I Colóquio Mulheres Pensantes do Cariri: Mulheres à margem: da invisibilidade ao lugar de fala",
            "Minicurso:Desvendando a Plataforma Lattes",
            "Minicurso: Ensino de Libras na área da Saúde: sinais para a utilização na comunicação básica",
            "Minicurso: “Libras para a comunicação básica",
            "Minicurso: Língua Inglesa para surdos/as como L3",
            "Minicurso: Língua Portuguesa como L2 para surdos/as",
            "Minicurso: “Tradução e Interpretação em diferentes contextos: relatos de pesquisas nos campos jurídico e da saúde”",
            "Minicurso: “O uso da Escrita de Sinais em Obras Literárias e Acadêmicas”",
            "Minicurso: “Transcrição em Escrita de Sinais”",
            "II Setembro Surdo da UFCA e II Seminário de Escrita da Língua de Sinais do Cariri",
            "IFE CAST: MINHA COMUNIDADE",
            "Renova MKS: Promovendo a Reciclagem de Óleo na UFCA",
            "Oficina: “Cultura Surda: Mitos e Verdades sobre os surdos e sua língua”",
            "I Setembro Surdo em Brejo Santo: Língua de Sinais, Identidade e Cultura Surda",
            "Oficina: “Libras para a comunicação básica”",
            "Matemática Básica e Jogos Matemáticos: Ensino Fundamental Anos Iniciais",
            "LIGA ACADÊMICA DE SAÚDE ÚNICA (LIASU)",
            "Jornada de aprendizado em análise de dados para alunos da rede pública de ensino do estado do Ceará",
            "Liga Acadêmica de Biomateriais - LABmat",
            "Doação de livros acessíveis para escolas da rede de ensino fundamental",
            "VENHA PARA A UFCA: Feira das Profissões do Centro de Ciências e Tecnologia 2023",
            "I Ciclo Formativo da PROAD",
            "XIV Semana da Agronomia",
            "Calang.io Empresa Júnior de Desenvolvimento de Software",
            "PLANEJAMENTO ESTRATÉGICO NO COMÉRCIO CARIRIENSE",
            "Produção de Recursos Educacionais Abertos para o Ensino de Matemática",
            "Power BI (Módulo II)",
            "Power BI (Módulo I)",
            "I COLÓQUIO DE FILOSOFIA, LITERATURA, CULTURA E TERRITÓRIO",
            "EXCEL Avançado",
            "Programa Eficiência",
            "O Ponto X da Tipografia",
            "Outro",
        ];

        foreach($projects as $project){
            if(!Projects::where('title', ucfirst(mb_strtolower(str_replace(["'", "`"], '', $project), 'UTF-8')))->first()){
                Projects::create([
                    "title" => ucfirst(mb_strtolower(str_replace(["'", "`"], '', $project), 'UTF-8'))
                ]);
            }
        }
        foreach($courses as $course){
            Courses::create([
                "name" => ucwords(mb_strtolower(str_replace(["'", "`"], '', $course), 'UTF-8'))
            ]);
        }
    }
}
