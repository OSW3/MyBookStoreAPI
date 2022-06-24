<?php 
namespace App\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControllerContext extends AbstractController
{
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Generate a basic response
     *
     * @param Request $request
     * @param Entity $data
     * @param string $index of the response in content API
     * @return array
     */
    protected function response(Request $request, $data, string $index): array
    {
        // Define the response array
        $response = [];

        // HEADER
        // --

        // Define the header of the response
        $response['header'] = [];

        // Time refereces
        $response['header']['datetime'] = date('Y-m-d H:i:s');
        $response['header']['timestamp'] = time();

        // Response code
        $response['header']['status'] = [];
        $response['header']['status']['code'] = Response::HTTP_OK;
        $response['header']['status']['text'] = Response::$statusTexts[Response::HTTP_OK];

        // Define the URI EndPoint
        $response['header']['endpoint'] = $request->getScheme()."://".$request->getHttpHost();



        // CONTENT
        // --
        
        // Define the content of the response
        $response['content'] = [];

        // Define the response subject
        $response['content'][$index] = $data;

        // Define pagination data
        $response['content']['pages'] = [];

        $response['content']['pages']['perPage'] = 20;
        $response['content']['pages']['current'] = 1;
        $response['content']['pages']['first'] = "/".$index."?page=1";
        $response['content']['pages']['prev'] = "/".$index."?page=9";
        $response['content']['pages']['next'] = "/".$index."?page=11";
        $response['content']['pages']['last'] = "/".$index."?page=42";

        return $response;
    }

}