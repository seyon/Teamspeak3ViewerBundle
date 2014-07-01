<?php

namespace Seyon\Teamspeak3\ViewerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ViewController extends Controller 
{
		
    /**
     * @Route("/ts3")
     * @return array
     */
    public function overviewAction()
    {
        
        $root = $this->container->getParameter('kernel.root_dir');

        /* load framework library */
        $frameworkRoot = $root."/../vendor/seyon/teamspeak3-framework/Seyon/Teamspeak3/Framework/";
        require_once($frameworkRoot."libraries/TeamSpeak3/TeamSpeak3.php");
 
        $html = '';
		
		try
		{
            
            $cfg = $this->container->getParameter('seyon_teamspeak3_viewer');

			/* connect to server, authenticate and get TeamSpeak3_Node_Server object by URI */
			$ts3 = \TeamSpeak3::factory("serverquery://" . $cfg["user"] . ":" . $cfg["pass"] . "@" . $cfg["host"] . ":" . $cfg["query"] . "/?server_port=" . $cfg["voice"] . "#no_query_clients");

			/* enable new display mode */
			$ts3->setLoadClientlistFirst(TRUE); 

			/* display viewer for selected TeamSpeak3_Node_Server */
			$viewer = new \TeamSpeak3_Viewer_Html("/bundles/seyonteamspeak3viewer/images/viewer/", "/bundles/seyonteamspeak3viewer/images/flags/", $frameworkRoot."examples/ts3icon.php");
			$html .= $ts3->getViewer($viewer);

			/* display runtime from adapter profiler */
			//$sHtml .= "<p>Executed " . $ts3->getAdapter()->getQueryCount() . " queries in " . $ts3->getAdapter()->getQueryRuntime() . " seconds</p>\n";
		}
		catch(TeamSpeak3_Adapter_ServerQuery_Exception $e)
		{
			/* echo error message */
			$html .= "<p><span class=\"error\"><b>ERROR 0x" . dechex($e->getCode()) . "</b>: " . htmlspecialchars($e->getMessage()) . "</span></p>";
		}

		$response = $this->render('SeyonTeamspeak3ViewerBundle:View:overview.html.twig', array(
			'ts3_overview'         => $html,
            'seyon_teamspeak3_viewer' => $this->container->getParameter('seyon_teamspeak3_viewer')
		));
		
		$response->setMaxAge($cfg['max_age']);
		$response->setSharedMaxAge($cfg['shared_max_age']);
		
        return $response;

    }
}