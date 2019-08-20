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
    'version'          => '0.1',
    'constraints'      => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99'
        ]
    ]
];
