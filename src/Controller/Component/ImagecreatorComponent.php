<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Net component
 */
class ImagecreatorComponent extends Component {

/**
 * Default configuration.
 *
 * @var array
 */

       public function getFileUploadLimit() {
           $max_file_size = ini_get('upload_max_filesize');
           if(preg_match('|([0-9]+)([a-z]+?)|i',$max_file_size,$match))
           {
              $qty = $match[1];
              if($unit = $match[2])
                switch(strtolower($unit))
                {
                  case 'k':
                    $qty *= 1024;
                    break;
                  case 'm':
                    $qty *= 1048576;
                    break;
                  case 'g':
                    $qty *= 1073741824;
                    break;
                }
                return $qty;
           }
           return $max_file_size;
       }

       public function uploadImageFile($filename,$srcname,$tmpfile,$filetype,$filepath,$filesize,$newheight=150){
           ini_set("gd.jpeg_ignore_warning", 1);
           $max_file_size	=	$this->getFileUploadLimit();
           $allowed = array('image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/jpg', 'image/pjpeg');
           //echo "test me";exit;
           if (!in_array($filetype, $allowed)) //To check if the file are image file
           {
                //$this->Flash->error(__('The file type is not valid'));
                return false;
           }elseif($max_file_size  <= $filesize){
              // $this->Flash->error(__('The file size is too large to upload'));
               return false;
           }
           else
           {
                      
                      $ext = pathinfo($srcname, PATHINFO_EXTENSION);
                      switch ($ext)
                      {
                             case 'jpeg':
                             case 'pjpeg':
                             case 'JPG':
                             case 'jpg':
                                    $src = ImageCreateFromJpeg($tmpfile);
                                    break;

                             case 'png':
                                    $src = ImageCreateFromPng($tmpfile);
                                    break;

                             case 'gif':
                                    $src = ImageCreateFromGif($tmpfile);
                                    break;

                      }

                           list($width,$height)=getimagesize($tmpfile);
                           //set file width to defined value
                           //echo $width."<br>".$height;
                           $newwidth=($width/$height)*$newheight;
                           //$newheight=($height/$width)*$newwidth;//the height are set according to ratio
                           //echo "<br>".$newwidth."<br>".$newheight; exit;
                           $tmp=imagecreatetruecolor($newwidth,$newheight);
                           imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);//resample the image

                           switch ($ext)
                      {
                           case 'jpeg':
                              case 'JPG':
                           case 'jpg':
                             $statusupload = imagejpeg($tmp,$filepath,100);//upload the image
                             break;
                           case 'png':
                             $statusupload =  imagepng($tmp,$filepath,9);//upload the image
                             break;
                            case 'gif':
                             $statusupload = imagegif($tmp,$filepath,100);//upload the image
                             break;

                      }
           }
           return true;
    }

    public function formatImage($srcname,$tmpfile,$newheight=150){
        ini_set("gd.jpeg_ignore_warning", 1);
        $ext = pathinfo($srcname, PATHINFO_EXTENSION);
        switch ($ext)
        {
             case 'jpeg':
             case 'pjpeg':
             case 'JPG':
             case 'jpg':
                    $src = ImageCreateFromJpeg($tmpfile);
                    break;

             case 'png':
                    $src = ImageCreateFromPng($tmpfile);
                    break;

             case 'gif':
                    $src = ImageCreateFromGif($tmpfile);
                    break;

              default:
                    $src = ImageCreateFromJpeg($tmpfile);
                    break;

        }

        list($width,$height)=getimagesize($tmpfile);
        //set file width to defined value
        //echo $width."<br>".$height;
        $newwidth=($width/$height)*$newheight;
        //$newheight=($height/$width)*$newwidth;//the height are set according to ratio
        //echo "<br>".$newwidth."<br>".$newheight; exit;
        $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);//resample the image

        switch ($ext)
        {
          case 'jpeg':
          case 'JPG':
          case 'jpg':
            imagejpeg($tmp,$tmpfile);//upload the image
          break;
          case 'png':
            imagepng($tmp,$tmpfile);//upload the image
          break;
          case 'gif':
            imagegif($tmp,$tmpfile);//upload the image
          break;
          default:
            imagejpeg($tmp,$tmpfile);//upload the image
          break;
        }
        

        return true;
    }
}
