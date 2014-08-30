<?php
class CreatMiniature  
{   
    //公共变量   
    var $srcFile="";        //原图   
    var $echoType;            //输出图片类型，link--不保存为文件；file--保存为文件   
    var $im="";                //临时变量   
    var $srcW="";            //原图宽   
    var $srcH="";            //原图高   
  
    //设置变量及初始化   
    function SetVar($srcFile,$echoType)   
    {   
        if (!file_exists($srcFile)){   
            echo '源图片文件不存在!';   
            exit();   
        }   
        $this->srcFile=$srcFile;   
        $this->echoType=$echoType;   

        $info = "";   
        $data = GetImageSize($this->srcFile,$info);   
        switch ($data[2])    
        {   
         case 1:   
           if(!function_exists("imagecreatefromgif")){   
            echo "你的GD库不能使用GIF格式的图片，请使用Jpeg或PNG格式！<a href='javascript:go(-1);'>返回</a>";   
            exit();   
           }   
           $this->im = ImageCreateFromGIF($this->srcFile);   
           break;   
        case 2:   
          if(!function_exists("imagecreatefromjpeg")){   
           echo "你的GD库不能使用jpeg格式的图片，请使用其它格式的图片！<a href='javascript:go(-1);'>返回</a>";   
           exit();   
          }   
          $this->im = ImageCreateFromJpeg($this->srcFile);       
          break;   
        case 3:   
          $this->im = ImageCreateFromPNG($this->srcFile);       
          break;   
      }   
      $this->srcW=ImageSX($this->im);   
      $this->srcH=ImageSY($this->im); 
    }   
       
    //生成扭曲型缩图   
    function Distortion($toFile,$toW,$toH)   
    {   
        $cImg=$this->CreatImage($this->im,$toW,$toH,0,0,0,0,$this->srcW,$this->srcH);   
        return $this->EchoImage($cImg,$toFile);   
        ImageDestroy($cImg);   
    }   
       
    //生成按比例缩放的缩图   
    function Prorate($toFile,$toW,$toH)   
    {   
        $toWH=$toW/$toH;   
        $srcWH=$this->srcW/$this->srcH;   
        if($toWH<=$srcWH)   
        {   
            $ftoW=$toW;   
            $ftoH=$ftoW*($this->srcH/$this->srcW);   
        }   
        else  
        {   
              $ftoH=$toH;   
              $ftoW=$ftoH*($this->srcW/$this->srcH);   
        }   
        if($this->srcW>$toW||$this->srcH>$toH)   
        {   
            $cImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);   
            return $this->EchoImage($cImg,$toFile);   
            ImageDestroy($cImg);   
        }   
        else  
        {   
            $cImg=$this->CreatImage($this->im,$this->srcW,$this->srcH,0,0,0,0,$this->srcW,$this->srcH);   
            return $this->EchoImage($cImg,$toFile);   
            ImageDestroy($cImg);   
        }   
    }   
       
    //生成最小裁剪后的缩图   
    function Cut($toFile,$toW,$toH)   
    {   
          $toWH=$toW/$toH;   
          $srcWH=$this->srcW/$this->srcH;   
          if($toWH<=$srcWH)   
          {   
               $ctoH=$toH;   
               $ctoW=$ctoH*($this->srcW/$this->srcH);   
          }   
          else  
          {   
              $ctoW=$toW;   
              $ctoH=$ctoW*($this->srcH/$this->srcW);   
          }    
        $allImg=$this->CreatImage($this->im,$ctoW,$ctoH,0,0,0,0,$this->srcW,$this->srcH);   
        $cImg=$this->CreatImage($allImg,$toW,$toH,0,0,($ctoW-$toW)/2,($ctoH-$toH)/2,$toW,$toH);   
        echo $this->EchoImage($cImg,$toFile);   
        ImageDestroy($cImg);   
        ImageDestroy($allImg);   
    }   
  
    //生成背景填充的缩图   
    function BackFill($toFile,$toW,$toH,$bk1=255,$bk2=255,$bk3=255)   
    {  
        $toWH=$toW/$toH;   
        $srcWH=$this->srcW/$this->srcH;   
        if($toWH<=$srcWH)   
        {   
            $ftoW=$toW;   
            $ftoH=$ftoW*($this->srcH/$this->srcW);   
        }   
        else  
        {   
              $ftoH=$toH;   
              $ftoW=$ftoH*($this->srcW/$this->srcH);   
        }   
        if(function_exists("imagecreatetruecolor"))   
        {   
            @$cImg=ImageCreateTrueColor($toW,$toH);   
            if(!$cImg)   
            {   
                $cImg=ImageCreate($toW,$toH);   
            }   
        }   
        else  
        {   
            $cImg=ImageCreate($toW,$toH);   
        }   
        $backcolor = imagecolorallocate($cImg, $bk1, $bk2, $bk3);        //填充的背景颜色   
        ImageFilledRectangle($cImg,0,0,$toW,$toH,$backcolor);   
        if($this->srcW>$toW||$this->srcH>$toH)   
        {        
            $proImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);   
             if($ftoW<$toW)   
             {   
                 ImageCopy($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH);   
             }   
             else if($ftoH<$toH)   
             {   
                 ImageCopy($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);   
             }   
             else  
             {   
                 ImageCopy($cImg,$proImg,0,0,0,0,$ftoW,$ftoH);   
             }   
        }   
        else  
        {   
             ImageCopyMerge($cImg,$this->im,($toW-$ftoW)/2,($toH-$ftoH)/2,0,0,$ftoW,$ftoH,100);   
        }  
        //return $this->EchoImage($cImg,$toFile); 
		ImageJpeg($cImg,$toFile); 
        ImageDestroy($cImg);   
    }   
       
  
    function CreatImage($img,$creatW,$creatH,$dstX,$dstY,$srcX,$srcY,$srcImgW,$srcImgH)   
    {   
        if(function_exists("imagecreatetruecolor"))   
        {   
            @$creatImg = ImageCreateTrueColor($creatW,$creatH);   
            if($creatImg)    
                ImageCopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);   
            else  
            {   
                $creatImg=ImageCreate($creatW,$creatH);   
                ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);   
            }   
         }   
         else  
         {   
            $creatImg=ImageCreate($creatW,$creatH);   
            ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);   
         }   
         return $creatImg;   
    }   
       
    //输出图片，link---只输出，不保存文件。file--保存为文件   
    function EchoImage($img,$to_File)   
    {   
        switch($this->echoType)   
        {   
            case "link":   
                if(function_exists('imagejpeg')) return ImageJpeg($img);   
                else return ImagePNG($img);   
                break;   
            case "file":   
                if(function_exists('imagejpeg')) return ImageJpeg($img,$to_File);   
                else return ImagePNG($img,$to_File);   
                break;   
        }   
    }   
}   
?> 