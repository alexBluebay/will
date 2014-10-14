<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{

    
   
    public function _initRoutes()
    {        
        $router = Zend_Controller_Front::getInstance()->getRouter();
        
                               // Categorii nav
        
        $route = new Zend_Controller_Router_Route('categorii/',
            array(
                'controller' => 'categorii',
                'action' => 'listare-categorii',
            ));

        $router->addRoute('listare_categorii', $route);
        
                               // Adaugare Link
        
        $route = new Zend_Controller_Router_Route('adauga/',
            array(
                'controller' => 'linkuri',
                'action' => 'adauga-link',
                
            ));
        
        $router->addRoute('adauga_link', $route);
                              
                                // Termeni si conditii
        
        $route = new Zend_Controller_Router_Route('termeni/',
            array(
                'controller' => 'pagini',
                'action' => 'termeni',
                
            ));
        
        $router->addRoute('termeni', $route);
        
                               // Contact
        
        $route = new Zend_Controller_Router_Route('contact/',
            array(
                'controller' => 'pagini',
                'action' => 'contact',
                
            ));
        
        $router->addRoute('contact', $route);
        
                               // Servicii Will
        
        $route = new Zend_Controller_Router_Route('servicii/',
            array(
                'controller' => 'pagini',
                'action' => 'servicii',
                
            ));
        
        $router->addRoute('servicii', $route);
        
                               // Avantaje Director Web
        
        $route = new Zend_Controller_Router_Route('avantaje/',
            array(
                'controller' => 'pagini',
                'action' => 'avantaje',
                
            ));
        
        $router->addRoute('avantaje', $route);
        
                               // Categorii
        
        $route = new Zend_Controller_Router_Route('categorii/:category/:categoryId',
            array(
                'controller' => 'categorii',
                'action' => 'listare-categorii',
                'category' => '',
                'categoryId' => '',
            ));
        
        $router->addRoute('listare_categorii', $route);
        
                               // Subcategorii
        $router->addRoute(
            'listare_subcategorii',
            new Zend_Controller_Router_Route_Regex('subcategorii-(\d+)-(.+)',
                array(
                    'module'        => 'default',
                    'controller'    => 'categorii',
                    'action'        => 'listare-subcategorii',
                    'category'  => '',
                    'categoryId'  => '',
                ),
                array(
                    'category' => 2,
                    'categoryId' => 1,
                ),
                'subcategorii-%d-%s'
            )
        );
        
                                // Listare Linkuri

        $router->addRoute(
            'listare_linkuri',
            new Zend_Controller_Router_Route_Regex('categorie-(\d+)-(.+)',
                array(
                    'module'        => 'default',
                    'controller'    => 'linkuri',
                    'action'        => 'listare-linkuri',
                    'subcategory'  => '',
                    'category'  => '',
                    'subcategoryId'  => '',
                ),
                array(
                    'subcategory' => 2,
                    'category' => 3,
                    'subcategoryId' => 1,
                ),
                'categorie-%d-%s'
            )
        );      
        
                                // Linkuri Detalii
        
         $router->addRoute(
            'detalii_link',
            new Zend_Controller_Router_Route_Regex('link-(\d+)-(.+)',
                array(
                    'module'        => 'default',
                    'controller'    => 'linkuri',
                    'action'        => 'detalii-link',
                    'title'  => '',
                    'linkId'  => '',
                ),
                array(
                    'title' => 2,
                    'linkId' => 1,
                ),
                'link-%d-%s'
            )
        );
        
                                // Linkuri Sponsor
        
        $route = new Zend_Controller_Router_Route ('/linksp/:title/:id',
                array(
                    'controller' => 'linkuri',
                    'action' => 'sponsor-link',
                    'title' => '',
                    'id' => '',
                ));
        $router->addRoute('sponsor_link', $route);
        
    
    }
    
    
}

