<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use OpenCloud\Rackspace;
use OpenCloud\ObjectStore\Resource\DataObject;

/**
 * Rackspace OpenCloud component
 */
class OpencloudComponent extends Component {

    public $cdn = NULL;
    public $client = NULL;
    public $container = NULL;
    public $objectStoreService = NULL;
    protected $_defaultConfig = [
		'username'    => 'marketingconnex',
		'apiKey'      => '24ebe7762ce1496fa4d71acb7b2cb48b',
        'region'      => 'LON',
        'container'   => 'partner_files',
	];

    public function __construct(ComponentRegistry $collection, array $config = array())
    {
        parent::__construct($collection, $config);
        $this->controller = $collection->getController();
    }
    
    public function connect()
    {
        $this->client = new Rackspace(Rackspace::UK_IDENTITY_ENDPOINT, array(
            'username' => $this->_defaultConfig['username'],
            'apiKey'   => $this->_defaultConfig['apiKey']
        )) or die('OpenCloud Client Failed to Connect');
        
        $this->objectStoreService = $this->client->objectStoreService(null, $this->_defaultConfig['region']) or die('OpenCloud Failed to Create Service');
        
        $this->container = $this->objectStoreService->getContainer($this->_defaultConfig['container']) or die('OpenCloud Failed to Fetch Container');
        
        $this->cdn = $this->container->getCdn();
    }
    
    public function listObjects($path='')
    {
        if(is_null($this->client))
            $this->connect();
        
        $files = array();
        $objs = $this->container->objectList($path?['path'=>$path]:NULL);
        foreach($objs as $obj)
        {
            $files[] = ['name'=>$obj->getName(),'temp_url'=>$obj->getTemporaryUrl(3600, 'GET'),'size'=>$obj->getContentLength(),'type'=>$obj->getContentType(),'container'=>$obj->getContainer()];
        }
        return $files;
    }
    
    public function addObject($filepath,$filesource='')
    {
        if(is_null($this->client))
            $this->connect();
        
        $data = fopen($filesource, 'r+');

        return $this->container->uploadObject($filepath, $data);
    }

    public function updateObject($filepath,$filesource='')
    {
        return $this->addObject($filepath,$filesource);
        /*
        if(is_null($this->client))
            $this->connect();

        $object = $this->container->getObject($filepath);

        $data = fopen($filesource, 'r+');

        $object->setContent($data);
        
        return $object->update();
        */
    } 

    public function replaceObject($filepath,$newfilepath,$filesource='')
    {
        if($this->deleteObject($filepath))
            return $this->addObject($newfilepath,$filesource);

        return false;
        /*
        if(is_null($this->client))
            $this->connect();

        $data = fopen($filesource, 'r+');

        if($this->container->uploadObject($newfilepath, $data))
        {
            $object = $this->container->getObject($filepath);
            return $object->delete();
        }
        return false;
        */
    }

    public function deleteObject($filepath)
    {
        if(is_null($this->client))
            $this->connect();

        $object = $this->container->getObject($filepath);

        return $object->delete();
    }

    public function downloadObject($filepath,$filename='')
    {
        if(is_null($this->client))
            $this->connect();

        $object = $this->container->getObject($filepath);

        header("Content-Disposition: attachment;filename=".($filename==''?$object->getName():$filename));
        header('Content-Type: '.$object->getContentType());
        header("Accept-Ranges: bytes");
        header("Pragma: public");
        header("Expires: -1");
        header("Cache-Control: no-cache");
        header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
        header("Content-Length: ".$object->getContentLength());

        print $object->getContent();
        ob_flush();
        flush();

    }

    public function getobjecturl($filepath)
    {
        if(is_null($this->client))
            $this->connect();

        $object = $this->container->getObject($filepath);
        
        return $object->getPublicUrl();
    }
}