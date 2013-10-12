<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'queryanalyzer' => array(
        'displayQueryAnalyzer' => true,
        //left OR right
        'button_position_horizontal'  => 'right',
        //top OR bottom
        'button_position_vertical'    => 'bottom',

        'log' => false,

        //Loggers
        'loggers' => array(
        )
    ),
);