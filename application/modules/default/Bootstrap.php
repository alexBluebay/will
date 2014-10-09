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
        $route = new Zend_Controller_Router_Route('/categorii/subcategorii/:category/:categoryId',
            array(
                'controller' => 'categorii',
                'action' => 'listare-subcategorii',
                'category' => '',
                'categoryId' => '',
            ));
        
        $router->addRoute('listare_subcategorii', $route);
        
                                // Listare Linkuri

        $route = new Zend_Controller_Router_Route('/listare-linkuri/:subcategory/:subcategoryId',
            array(
                'controller' => 'linkuri',
                'action' => 'listare-linkuri',
                'subcategory' => '',
                'subcategoryId' => '',
            ));
        
        $router->addRoute('listare_linkuri', $route);       
        
                                // Linkuri Detalii
        
        $route = new Zend_Controller_Router_Route('/link/:title/:linkId',
                array(
                    'controller' => 'linkuri',
                    'action' => 'detalii-link',
                    'title' => '',
                    'linkId' => '',
                ));
        $router->addRoute('detalii_link', $route);
        
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

