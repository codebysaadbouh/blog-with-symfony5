<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 

class HelloController {

    
    /**
     * @Route("/hello")
     */
    public function Hello() : Response{
         return new Response("Hello World"); 
    }

    /**
     * @Route("/hello/{name}")
     */
    public function HelloName($name) : Response {
    return new Response('Hello '.$name);
    }

}
