<?php
namespace Tools;

/**
 * Description of MyTwig
 *
 * @author yousra.elyebdri
 */
abstract class MyTwig {
    private static function getLoader(){
        
        $loader = new \Twig\Loader\FilesystemLoader(PATH_VIEW);//Dossier contenant les templates
        //pas de cache en mode debug
        $environmentTwig = new \Twig\Environment($loader, [
            'cache'=> false,
            'debug'=> true ,
         ]);
        $environmentTwig->addExtension(new \Twig\Extension\DebugExtension());
        return $environmentTwig;
    }
    
    public static function afficheVue($vue, $params){
        $twig = self::getLoader();
        
        $template = $twig->load($vue);
        echo $template->render($params);
    }
}
