<?php
// Este arquivo simula um banco de dados de veículos.
// No futuro, isso pode ser substituído por uma conexão a um banco de dados real (MySQL, PostgreSQL, etc.).

$veiculos = [
    [
        'id' => 1,
        'marca' => 'Nissan',
        'modelo' => 'Skyline GT-R R34',
        'ano' => 2001,
        'preco' => 550000.00,
        'motor' => '2.6L Twin-Turbo RB26DETT',
        'potencia' => '650cv',
        'imagem_principal' => 'images/skyline-r34.jpg', // Coloque a imagem correspondente nesta pasta
        'modificacoes' => [
            'Turbinas Garrett GT2860R',
            'Intercooler GReddy Spec-R',
            'Suspensão Coilover Tein Mono Sport',
            'Rodas Volk Racing TE37',
            'Sistema de exaustão HKS Super Turbo',
            'ECU HKS F-CON V Pro'
        ]
    ],
    [
        'id' => 2,
        'marca' => 'Toyota',
        'modelo' => 'Supra MK4',
        'ano' => 1998,
        'preco' => 480000.00,
        'motor' => '3.0L Twin-Turbo 2JZ-GTE',
        'potencia' => '700cv',
        'imagem_principal' => 'images/supra-mk4.jpg', // Coloque a imagem correspondente nesta pasta
        'modificacoes' => [
            'Kit single turbo Precision 6870',
            'Injeção programável FuelTech FT600',
            'Pistões forjados CP Carrillo',
            'Bielas forjadas Manley',
            'Sistema de freios Brembo GT',
            'Body kit RIDOX'
        ]
    ],
    [
        'id' => 3,
        'marca' => 'Honda',
        'modelo' => 'Civic Si "K24 Turbo"',
        'ano' => 2008,
        'preco' => 95000.00,
        'motor' => '2.4L K24 Turbo',
        'potencia' => '450cv',
        'imagem_principal' => 'images/civic-si.jpg', // Coloque a imagem correspondente nesta pasta
        'modificacoes' => [
            'Motor K24 com kit turbo SPA',
            'Intercooler frontal',
            'Embreagem de cerâmica',
            'Suspensão preparada',
            'Rodas Enkei RPF1 17"',
            'Interior com bancos concha'
        ]
    ],
    [
        'id' => 4,
        'marca' => 'Volkswagen',
        'modelo' => 'Golf GTI MK7 Stage 3',
        'ano' => 2016,
        'preco' => 180000.00,
        'motor' => '2.0L TSI EA888 Gen. 3',
        'potencia' => '480cv',
        'imagem_principal' => 'images/golf-gti.jpg', // Coloque a imagem correspondente nesta pasta
        'modificacoes' => [
            'Turbina Is38 Híbrida',
            'Remap de ECU e TCU (Stage 3)',
            'Downpipe em inox 3"',
            'Catback com abafador em inox',
            'Kit de molas esportivas Eibach',
            'Intake de alta performance'
        ]
    ]
];
?>