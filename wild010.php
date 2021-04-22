<?php


function readpath($dir,$level,$last,&$dirs,&$files)
{
print $dir." (DIR)<br/>\n";

$thumbs_folder="thumbs"; // folder where thumbs will go
$thumbs_width=""; // set width for thumbnail, or
$thumbs_height=""; // set height for thumbnail, or
$thumbs_autosize="220";  // set the biggest width or height for thumbnail
$thumbs_quality="90";  // [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75

$d = opendir("$dir");
while (false !== ($file = readdir($d)) && $level == $last) {
if ($file!="." && $file!="..")
                {

  if ( filetype($file) == 'file' ){
    $type = ereg_replace(".*\.(.*)$","\\1",$file);
    if ( preg_match("/^(png|gif|jpg|jpeg)$/i",$type) ) {
      if ( !file_exists  ($thumbs_folder."/".$file) ) {
        echo "Resizing: ".$file."<br>";
        $thumb=new thumbnail($file);// generate image_file, set filename to resize
        if ($thumbs_width) {$thumb->size_width($thumbs_width);}
        if ($thumbs_height) {$thumb->size_width($thumbs_height);}
        if ($thumbs_autosize) {$thumb->size_auto($thumbs_autosize);}
        if ($thumbs_quality) {$thumb->jpeg_quality($thumbs_quality);}
        $thumb->save($thumbs_folder."/".$file);
      }
    }
  }

  else 
{
echo "here $dir"."/".$file."\n";
//readpath($dir."/".$file,$level+1,$last,$dirs,$files); // uses recursion
	$dirs[] = "$dir/$file";  
}
}
}

}
class thumbnail
{
    var $img;

    function thumbnail($imgfile)
    {
        //detect image format
        $this->img["format"]=ereg_replace(".*\.(.*)$","\\1",$imgfile);
        $this->img["format"]=strtoupper($this->img["format"]);
        if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
            //JPEG
            $this->img["format"]="JPEG";
            $this->img["src"] = ImageCreateFromJPEG ($imgfile);
        } elseif ($this->img["format"]=="PNG") {
            //PNG
            $this->img["format"]="PNG";
            $this->img["src"] = ImageCreateFromPNG ($imgfile);
        } elseif ($this->img["format"]=="GIF") {
            //GIF
            $this->img["format"]="GIF";
            $this->img["src"] = ImageCreateFromGIF ($imgfile);
        } elseif ($this->img["format"]=="WBMP") {
            //WBMP
            $this->img["format"]="WBMP";
            $this->img["src"] = ImageCreateFromWBMP ($imgfile);
        } else {
            //DEFAULT
            echo "Not Supported File";
            return;
        }
        @$this->img["lebar"] = imagesx($this->img["src"]);
        @$this->img["tinggi"] = imagesy($this->img["src"]);
        //default quality jpeg
        $this->img["quality"]=90;
    }

    function size_height($size=100)
    {
        //height
        $this->img["tinggi_thumb"]=$size;
        @$this->img["lebar_thumb"] = 
($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
    }

    function size_width($size=100)
    {
        //width
        $this->img["lebar_thumb"]=$size;
        @$this->img["tinggi_thumb"] = 
($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
    }

    function size_auto($size=100)
    {
        //size
        if ($this->img["lebar"]>=$this->img["tinggi"]) {
            $this->img["lebar_thumb"]=$size;
            @$this->img["tinggi_thumb"] = 
($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
        } else {
            $this->img["tinggi_thumb"]=$size;
            @$this->img["lebar_thumb"] = 
($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
         }
    }

    function jpeg_quality($quality=90)
    {
        //jpeg quality
        $this->img["quality"]=$quality;
    }

    function show()
    {
        //show thumb
        @Header("Content-Type: image/".$this->img["format"]);

        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor 
function*/
        $this->img["des"] = 
ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
            @imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, 
$this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
            //JPEG
            imageJPEG($this->img["des"],"",$this->img["quality"]);
        } elseif ($this->img["format"]=="PNG") {
            //PNG
            imagePNG($this->img["des"]);
        } elseif ($this->img["format"]=="GIF") {
            //GIF
            imageGIF($this->img["des"]);
        } elseif ($this->img["format"]=="WBMP") {
            //WBMP
            imageWBMP($this->img["des"]);
        }
    }

    function save($save="")
    {
        //save thumb
	mkdir ("./thumbs");
        if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);
        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor 
function*/
        $this->img["des"] = 
ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
            @imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, 
$this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
            //JPEG
            imageJPEG($this->img["des"],"$save",$this->img["quality"]);
        } elseif ($this->img["format"]=="PNG") {
            //PNG
            imagePNG($this->img["des"],"$save");
        } elseif ($this->img["format"]=="GIF") {
            //GIF
            imageGIF($this->img["des"],"$save");
        } elseif ($this->img["format"]=="WBMP") {
            //WBMP
            imageWBMP($this->img["des"],"$save");
        }
    }
}

$level=1;  // level is the first level started at
$last=1; //this is set the same as level so the script does not read all directories, and only one 
$dirs = array();  // SET dirs as an ARRAY so it can be read
$files = array(); //SET files as an ARRAY so it can be read
$start_dir = "."; 

readpath($start_dir,$level, $last, $dirs,$files);

?> 
