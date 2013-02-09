<?

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

        /* load framework library */
        require_once("/../../Framework/libraries/TeamSpeak3/TeamSpeak3.php");

        $html = '';
		
		try
		{
			$cfg = array();
			$cfg['user'] = 'seyon';
			$cfg['pass'] = 'NBt1h4vT';
			$cfg['host'] = 'ts.finalfantasy-14.de';
			$cfg['query'] = '10011';
			$cfg["voice"] = '8987';

			/* connect to server, authenticate and get TeamSpeak3_Node_Server object by URI */
			$ts3 = \TeamSpeak3::factory("serverquery://" . $cfg["user"] . ":" . $cfg["pass"] . "@" . $cfg["host"] . ":" . $cfg["query"] . "/?server_port=" . $cfg["voice"] . "#no_query_clients");

			/* enable new display mode */
			$ts3->setLoadClientlistFirst(TRUE); 

			/* display viewer for selected TeamSpeak3_Node_Server */
			$viewer = new \TeamSpeak3_Viewer_Html("/bundles/cmstemplate/finalfantasy/images/teamspeak/", "/bundles/cmstemplate/finalfantasy/images/flags/", "/bundles/cmstemplate/finalfantasy/images/teamspeak/ts3icon.php");
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
		));
		
		$response->setMaxAge(120);
		$response->setSharedMaxAge(120);
		
        return $response;

    }
}