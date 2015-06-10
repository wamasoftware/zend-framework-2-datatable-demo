<?php

Namespace Datatabledemo;

return array(
    'controllers' => array(
        'invokables' => array(
            'Datatabledemo\Controller\Datatabledemo' => 'Datatabledemo\Controller\DatatabledemoController',
        )
    ),
    'router' => array(
        'routes' => array(
            'datatable' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/datatable[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Datatabledemo\Controller\Datatabledemo',
                        'action' => 'index'
                    ),
                ),
            ),
            'product' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/datatable/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Datatabledemo\Controller\Datatabledemo',
                        'action' => 'product'
                    ),
                ),
            ),
            
            'deleteproduct' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/datatable/deleteproduct[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Datatabledemo\Controller\Datatabledemo',
                        'action' => 'deleteproduct'
                    ),
                ),
            ),
           
          
        )
    ),
   
    'service_manager' => array(
        'invokables' => array(
            'Datatabledemo\Model\product' => 'Datatabledemo\Model\product',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'datatabledemo' => __DIR__ . '/../view'
        )
    ),
    'module_layouts' => array(
        'Datatabledemo' => 'layout/layout',
    ),
   
    'template_map' => array(
        'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
    ),
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'product_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Datatabledemo/Model/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Model\Entity' => __NAMESPACE__ . '_driver',
                    'Datatabledemo\Model\Entity' => 'product_driver',
                )
            )
        )
    )
);
