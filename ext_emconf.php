<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Form reCAPTCHA',
    'description'      => 'Adds Google\'s reCAPTCHA to EXT:form',
    'category'         => 'services',
    'author'           => 'Tobias Kretschmann',
    'author_email'     => 't.kretschmann@neusta.de',
    'author_company'   => 'Neusta GmbH',
    'state'            => 'stable',
    'uploadfolder'     => '0',
    'clearCacheOnLoad' => 1,
    'version'          => '2.0.1',
    'constraints'      => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'form' => '10.4.0-10.4.99'
        ]
    ]
];
