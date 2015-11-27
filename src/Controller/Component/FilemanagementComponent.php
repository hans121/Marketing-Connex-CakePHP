<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use DirectoryIterator;


/**
 * Net component
 */
class FilemanagementComponent extends Component {
    public $allowed_resource_file_types =   array();
     public $components = ['Session','Flash'];
/**
 * Default configuration.
 *
 * @var array
 */

    public function fileUploadLimit() {
       $max_file_size = ini_get('upload_max_filesize');
       if(preg_match('|([0-9]+)([a-z]+?)|i',$max_file_size,$match))
       {
          $qty = $match[1];
          $unit = $match[2];
          switch($unit){
            case 'G': 
                $qty = $qty * 1073741824;
            case 'M':
                $qty = $qty * 1048576;
            case 'K':
                $qty = $qty * 1024;
          }
          return $qty;
       }
       return $max_file_size;
    }

    public function sanitizeFileFoldername($string = '', $is_filename = FALSE)
    {
        // Replace all weird characters with dashes
        $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);

        // Only allow one dash separator at a time (and make string lowercase)
        return mb_strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
    }
    public function createFilesFolder($name=null,$path=null){
        if($name != null && $path != null){
            $structure = WWW_ROOT  .'files' . DS .$path.$name;
            if (mkdir($structure, 0777, true)) {
                $myfile = fopen($structure.DS."index.html", "w") ;
                $txt = __('<h1>404 File Not Found</h1><p>Sorry! The file you are trying to access is not found</p>');
                fwrite($myfile, $txt);
                fclose($myfile);
                return true;
            }
        }
        return false;
    }
    public function uploadFiletoFolder($file=array(),$folder=null){
        $max_file_size	=	$this->fileUploadLimit();//ini_get('upload_max_filesize') * 1024;
        //echo $max_file_size .': Original :'.$file['size'];exit;
        $return['filename'] =   false;
        $return['success'] =  0; // code for error
        $return['msg'] =   __('Error');
        if(!empty($file) && $folder != null){
	        
            $returnfilename = time().basename($file['name']); 
            $newfilename = WWW_ROOT  .'files' . DS .$folder.$returnfilename; 
            if($file['size'] > $max_file_size){
                $return['msg'] =   __('The file size is greater than the size allowed for a single file. ');
            }elseif($file['error'] != '0'){
                $return['msg'] =  __('The file is corrupted :').$file['error'];
            }elseif(!in_array($file['type'],$this->allowed_resource_file_types)){
                $return['msg'] =  __('The file type is not allowed to upload');
            }else{
	            //print_r($file["tmp_name"]); echo "<hr>";print_r($newfilename); 
	            
                if( move_uploaded_file($file["tmp_name"],$newfilename)){
                    $return['filename'] =   $returnfilename;
                    $return['success'] =  200; // code for sucess
                    $return['msg'] =    __('Ok');
                }
                
                //echo $return['msg'] ; exit;
            }
            
            
        }
        return $return;
    }
    /*
     * Function to download a file....
     */
    function download($filePath,$filename=null,$forcetype=false)
    {    
        $filePath   =   WWW_ROOT  .'files' . DS .$filePath;
       // echo $filePath;exit;
        if(!empty($filePath))
        {
            $fileInfo = pathinfo($filePath);
            
            //echo $fileInfo['basename'];exit;
            $fileExtnesion   = $fileInfo['extension'];
            if($filename == null){
                $fileName  = $fileInfo['basename'];
            }else{
                $fileName  = $this->sanitizeFileFoldername($filename).'.'.$fileExtnesion;
            }
            //$contentType =  $fileExtnesion;
            $finfo = finfo_open();
 
            $contentType = $forcetype===false ? finfo_file($finfo, $filePath, FILEINFO_MIME) : $forcetype;

            finfo_close($finfo);
            /*
             * application/pdf; charset=binary
             * application/pdf; charset=binary
             */
            if(file_exists($filePath))
            {
                $size = filesize($filePath);
                $offset = 0;
                $length = $size;
                //HEADERS FOR PARTIAL DOWNLOAD FACILITY BEGINS
                if(isset($_SERVER['HTTP_RANGE']))
                {
                    preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
                    $offset = intval($matches[1]);
                    $length = intval($matches[2]) - $offset;
                    $fhandle = fopen($filePath, 'r');
                    fseek($fhandle, $offset); // seek to the requested offset, this is 0 if it's not a partial content request
                    $data = fread($fhandle, $length);
                    fclose($fhandle);
                    header('HTTP/1.1 206 Partial Content');
                    header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $size);
                }//HEADERS FOR PARTIAL DOWNLOAD FACILITY BEGINS
                //USUAL HEADERS FOR DOWNLOAD
                header("Content-Disposition: attachment;filename=".$fileName);
                header('Content-Type: '.$contentType);
                header("Accept-Ranges: bytes");
                header("Pragma: public");
                header("Expires: -1");
                header("Cache-Control: no-cache");
                header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
                header("Content-Length: ".filesize($filePath));
                $chunksize = 8 * (1024 * 1024); //8MB (highest possible fread length)
                if ($size > $chunksize)
                {
                  $handle = fopen($_FILES["file"]["tmp_name"], 'rb');
                  $buffer = '';
                  while (!feof($handle) && (connection_status() === CONNECTION_NORMAL)) 
                  {
                    $buffer = fread($handle, $chunksize);
                    print $buffer;
                    ob_flush();
                    flush();
                  }
                  if(connection_status() !== CONNECTION_NORMAL)
                  {
                    $this->Flash->error(__('Connection aborted'));
                  }
                  fclose($handle);
                }
                else 
                {
                  //ob_clean();
                  //flush();
                  readfile($filePath);
                }
                exit;
             }
             else
             {
               $this->Flash->error(__('File does not exist!'));
             }
        }
        else
        {
            $this->Flash->error(__('There is no file to download!'));
        }
        
        return true;
    }    
    
    /*
     * Function to rename a folder
     */
    function renameFolder($newname,$oldname){
        return rename ( WWW_ROOT  .'files' . DS . $oldname , WWW_ROOT  .'files' . DS . $newname );
    }
    /*
     * Function to remove file
     */
    function removeFile($filename){
        unlink(WWW_ROOT  .'files' . DS . $filename );
        return true;
    }
    /*
     * Function to create and download csv file from a single PHP array
     */
    public function getExportcsv($array=array(),$filename, $delimiter=','){
	    //echo var_dump($array);
	    //echo $filename;
        // open raw memory as file so no temp files needed, you might run out of memory though
        $filePath   =   WWW_ROOT  .'files' . DS .'tempreports'.DS.$filename;
        //echo $filePath;
        $f = fopen($filePath, 'w'); 
        // loop over the input array
	        foreach ($array as $line) {
		       /// echo '<br>' . $line .'<br>';
	            // generate csv lines from the inner arrays
	            fputcsv($f, $line, $delimiter);   
	        }
        
        // rewrind the "file" with the csv lines
        fseek($f, 0);
        $this->download('tempreports'.DS.$filename);
        exit;
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
	public function delete_dir($path) {
		// Remove a dir (all files and folders in it)
		$i = new DirectoryIterator($path);
		foreach($i as $f) {
			if($f->isFile()) {
				unlink($f->getRealPath());
			} else if(!$f->isDot() && $f->isDir()) {
				$this->delete_dir($f->getRealPath());
				rmdir($f->getRealPath());
			}
		}
	}

	
    //public function exportcsvtemplate($filename) {
	  //  $filePath   =   WWW_ROOT  .'files' . DS .$filename;
	    //fopen($filepath, 'w');
    //}

    /*
     * Function to create and download csv file from a multidimensional PHP array
     */
    public function getExportcsvMulti($array=array(),$filename, $delimiter=','){
        // open raw memory as file so no temp files needed, you might run out of memory though
        $filePath   =   WWW_ROOT  .'files' . DS .'tempreports'.DS.$filename;
        $f = fopen($filePath, 'w'); 
        // loop over the input array
        $i=0;
        foreach ($array as $upperlayer) {
	        //$array[] = "\n";
	        foreach ($upperlayer as $line) {
	            // generate csv lines from the inner arrays
	            fputcsv($f, $line, $delimiter);   
	        }
	    
	   
	    $i++;
	     
	    
        }
        
        // rewrind the "file" with the csv lines
        fseek($f, 0);
        $this->download('tempreports'.DS.$filename);
        exit;
    }
    
    /**
	 * Import public function
	 *
	 * @param string $filename path to the file under webroot
	 * @return array of all data from the csv file in [Model][field] format
	 * @author Dean Sofer
	 */
	public function import($filename, $fields = array(), $options = array()) {
		$defaults = array(
		'length' => 0,
		'delimiter' => ',',
		'enclosure' => '"',
		'escape' => '\\',
		'headers' => true
	);		
		ini_set("auto_detect_line_endings", 1); 
		$options = array_merge($defaults, $options);
		$data = array();

		// open the file
		if ($file = fopen($filename, 'r')) {
			
			if (empty($fields)) {
				// read the 1st row as headings
				//echo "fields is empty"; exit;
				$fields = fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure'], $options['escape']);
			}
			// Row counter
			$r = 0;
			// read each data row in the file
			while ($row = fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure'], $options['escape'])) {
				// for each header field
				foreach ($fields as $f => $field) {
					// get the data field from Model.field
					if (strpos($field,'.')) {
						$keys = explode('.',$field);
						if (isset($keys[2])) {
							$data[$r][$keys[0]][$keys[1]][$keys[2]] = $row[$f];
						} else {
							$data[$r][$keys[0]][$keys[1]] = $row[$f];
						}
					} else {
						$data[$r][$this->controller->modelClass][$field] = $row[$f];
					}
				}
				$r++;
			}

			// close the file
			fclose($file);

			 //return the messages
			return $data;
		} else {
			$this->Flash->error('There was a problem importing the file, please ensure the file is a CSV file');
			return false;
			return $this->redirect(array('controller' => 'vendors', 'action' => 'partners'));
		}
	}
    
}
