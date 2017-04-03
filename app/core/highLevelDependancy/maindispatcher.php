<?php
namespace App\Core\HihgLevelDependacy;

use Lib\HelperService;
/**
 * the router class due to the url choose the appropriate controller
 * Class MainDispatcher
 * @package App\Core\Upper
 */
abstract class MainDispatcher
 {

    public $url;


    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];

    }


    /**
	 * get the url-path, defines controller itself and its action + 404 redirection
	 * @return array
	 */
	public function getController(){

        $controller= [];

        if(!is_array($this->url) && !empty($this->url)) {
            if ($this->url == 'admin') { $controller[0] = 'index'; $controller[1] = 'index'; $controller['admin'] = 'admin';
            } else {
                $controller[0] = $this->url; $controller[1] = 'index';
            }
        }

		if(empty($this->url)){$controller[0]= 'index'; $controller[1]= 'index';}


            if(empty($controller) AND is_array($this->url)) {

                if($this->url[0] == 'admin'){
                    $controller['admin'] = 'admin'; $controller[0]= $this->url[1]; $controller[1] = $this->url[2]?? 'index';
                } else {
                    $controller = $this->url;
                }
		}
//404 redirection

        if( isset($controller['admin'])){$class = '\App\Controllers\Admin\\'; } else {
            {$class = '\App\Controllers\\'; }
        }

		if(
            !class_exists($class.ucfirst($controller[0])) OR
            !method_exists($class.ucfirst($controller[0]), $controller[1] )
        )
        { $controller[0] = 'error_404'; $controller[1] = 'index'; }


		return $controller;
	}

    /**
     *
     * liquidate GET variable from URL
     * @return string
     */
	private function getRidOfGET()
	{
        $url = trim($this->url, '/');
//cast information after &
		if(stripos($url, '?')!== false){ $url = explode('?', $url);   $url= $url[0];}
        $this->url = $url;
	}


    /**
     * get free from language component url and language component itself
     * @param $url
     * @return array|string
     */
    protected function getLanguageComponent()
    {
        $url = $this->url;
        //if string to explode then explode into array
        if(strripos($url, '/')!== false ) {
            $url = explode('/', $url); $lang= $url[0];
        }
        //if this is just a string
        if(is_string($url)){ $lang = $url;}

        $langs = HelperService::prozessLangArray();

        //check if the posible language is present in Language list
        if (array_key_exists($lang, $langs)){
            $currentLang = $lang;
        //make url cleaner
            if(is_string($url)) $url='';
            if(is_array($url)) {
                array_shift($url);
                if(count($url)==1) { $url= $url[0]; }
            }
        }
        else {
            $currentLang = DEFAULT_LANG;
        }
        $this->url = $url;
        return $currentLang;
    }

    /**
     * get Language component from Url
     * @return array|string
     */
    public function getCurrentLanguage()
    {
        $this->getRidOfGET();

        $currentLang =  $this->getLanguageComponent();

        return $currentLang;
    }



    /**
     *
     * fire of a controller
     * @param $controller
     * @return mixed
     */
    abstract function runController($controller);

    /**
     *
     * get Path to view layout
     * @param $view
     * @return mixed
     */
    abstract function getView($view);

 }
 
 
?>
