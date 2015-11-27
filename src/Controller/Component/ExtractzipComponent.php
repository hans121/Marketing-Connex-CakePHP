<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;
use Cake\Routing\Router;
use Cake\Collection\Collection;
use ZipArchive;
use DirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DOMDocument;
use DOMXPath;

class ExtractzipComponent extends Component {
	
	public $components = array();
    public $settings = array();
    public $Controller = null;
    public $zip = null;
		
	
    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);
        
        // initialize callback urls
        $router = new Router();
        $baseurl = $router->url('/', true);
       
        
        $this->controller = $collection->getController();
		
        $this->http = new Client();
		
		// Load in PHP extension ZIP...?
        if(extension_loaded('zip')==true){
            $this->zip = new ZipArchive();
            $this->Controller = $collection->getController();
        }else{
            throw new MissingComponentException(__('Error: Not Load extension "ZIP" in PHP.INI!!'));
        }
       
	    $this->controller->loadModel('EmailTemplates');
		$this->EmailTemplates = $this->controller->EmailTemplates;
		
		/*
       
        // prefetch partner details
        $this->Partners = $this->controller->Partners;        
        $this->partner_id = $this->controller->Auth->user('partner_id');
        $this->partner = $this->Partners->get($this->partner_id);
        // end prefetch
       */ 
    }
	
	public function extract($file,$template_id=null,$vendor_id,$campaign_id) {
		$return['folder'] = false;
		$return['message'] = false;
		$return['folderContainer'] = "";
		$zip = $this->zip;
		$directory = WWW_ROOT .'files'.DS.'temp_importemailtemplate'.DS;
		$x = $zip->open($directory.DS.$file);
		if ($x === true) {
						
			$zip->extractTo($directory); 
			$zip->close();
			$this->rmdirr($directory."__MACOSX"); //remove mac
			unlink($directory.$file);
			$return['message'] = $x;
		}
		
		$noSub = $this->scanNoSub($directory);
		$withSub = $this->scanSubFolders($directory);
		
		if(count($noSub)){
			$html = $directory.$noSub[0];
		
			$source = WWW_ROOT .'files'.DS.'temp_importemailtemplate';
			$dist = WWW_ROOT .'files'.DS.'importemailtemplate'.DS."vendor-{$vendor_id}-campaign-{$campaign_id}";
			$this->recurse_copy($source,$dist);// copy file folder
			
			
			$return['folderContainer'] = "no";
			
			
		}elseif(count($withSub)){
			$html = $directory.$withSub[0].DS.$withSub[1];
			$return['folder'] = $withSub[0];
			$return['folderContainer'] = "yes";
		}
		//start processing the images directory
		$file = @file_get_contents($html);
		$doc = new DOMDocument();
		@$doc->loadHTML($file);
		$xpath = new DOMXPath($doc);
		
		$image_list = $xpath->query("//img[@src]");
		
		
		$dir = new DirectoryIterator(realpath($directory.$return['folder']));
		$dirName = array();
		foreach ($dir as $fileInfo) {
			if($fileInfo->isDir() && $fileInfo != "." && $fileInfo !="..") {
				//echo $fileInfo;
				array_push($dirName,$fileInfo->getFilename());
		
			}
		}
				
		
		for($i=0;$i<$image_list->length; $i++){
			 
			 $src = $image_list->item($i)->getAttribute("src");
			 if(strpos($src, "http://") === false && strpos($src, "https://") === false){
				 $src = explode("/",$src);
				 $img = $src[count($src) - 1];
				 $image_url  = Router::url('/files/importemailtemplate/',true);
				 $new_img = $image_url."vendor-{$vendor_id}-campaign-{$campaign_id}/".$dirName[0]."/".$img;
				 $image_list->item($i)->setAttribute("src",$new_img);
			 }
		}
		
		$doc->saveHTMLFile($html);
		
		
		$new_file = @file_get_contents($html);
		if($template_id){
			$query = $this->EmailTemplates->query();
			$query->update()
				->set(['custom_template' => $new_file])
				->where(['id' => $template_id])
				->execute();
		}else{
			$query = $this->EmailTemplates->query();
			$query->insert(['vendor_id', 'campaign_id','use_templates','custom_template'])
				->values([
					'vendor_id' => $vendor_id,
					'campaign_id' => $campaign_id,
					'use_templates' => '',
					'custom_template' => $new_file
				])
				->execute();
		}
		return $return;
	}
	public function scanNoSub($directory) {
		$result = array();
		$extensions = array('htm', 'html');
		$scanDir = new DirectoryIterator($directory);
		// iterate
		foreach ($scanDir as $fileinfo) {
			// must be a file
			if ($fileinfo->isFile()) {
				// file extension
				$extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
				// check if extension match
				if (in_array($extension, $extensions)) {
					// add to result
					$result[] = $fileinfo->getFilename();
				}
			}
		}
		return $result;
	}
	public function scanSubFolders($directory){
		$result = array();
		$extensions = array('htm', 'html');
		$scanDir = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($directory)
		);
		foreach ($scanDir as $fileinfo) {
			// must be a file
			
			if ($fileinfo->isFile()) {
				// file extension
				$extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
				// check if extension match
				if (in_array($extension, $extensions)) {
					// add to result
					$result[] = $fileinfo->getFilename();
				}
			}
		}
		//get dir name
		if($handle = opendir($directory)){
			while(false !== ($entry = readdir($handle))){
				if ($entry != "." && $entry != "..") {
					$dir = $entry;
				}
			}
		}
		return [$dir,$result[0]];
	}
	public function rmdirr($dirname){
		// Sanity check
		if (!file_exists($dirname)) {
			return false;
		}
	 
		// Simple delete for a file
		if (is_file($dirname) || is_link($dirname)) {
			return unlink($dirname);
		}
	 
		// Loop through the folder
		$dir = dir($dirname);
		while (false !== $entry = $dir->read()) {
			// Skip pointers
			if ($entry == '.' || $entry == '..') {
				continue;
			}
	 
			// Recurse
			$this->rmdirr($dirname . DS . $entry);
		}
	 
		// Clean up
		$dir->close();
		return rmdir($dirname);
	}
	public function mkdir_r($dirName, $rights=0777){
		$dirs = explode('/', $dirName);
		$dir='';
		foreach ($dirs as $part) {
			$dir.=$part.'/';
			if (!is_dir($dir) && strlen($dir)>0)
				mkdir($dir, $rights);
		}
	}
	public function recurse_copy($src,$dst) { 
		$dir = opendir($src); 
		$this->mkdir_r($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				if ( is_dir($src . DS . $file) ) { 
					
					$this->recurse_copy($src . DS . $file,$dst . DS . $file); 
				}else { 
					copy($src . DS . $file,$dst . DS . $file); 
				} 
			} 
		} 
		
		closedir($dir); 
		
	}
	private function _parse($resp) {
		$good_codes = ['200','201'];
		return !in_array($resp->code,$good_codes) ? false : json_decode($resp->body);
	}
	
}