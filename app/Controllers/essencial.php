

<?php

    define('SITE_URL','/Projecto-Final/');
    define('ABOUT_IMAGE_PATH',SITE_URL.'public/media/');
    define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Projecto-Final/public/media/');
    //define('ABOUT_FOLDER','about/image');
    define('USER_FOLDER','users/');
    define('QUARTO_FOLDER','quarto/');
    define('ACOMADACAO_FOLDER','icons_acomodacao/');

    define('ACOMADACAO_IMAGE_PATH',ABOUT_IMAGE_PATH.ACOMADACAO_FOLDER);
    define('USER_IMAGE_PATH',ABOUT_IMAGE_PATH.USER_FOLDER);
    define('QUARTO_IMAGE_PATH',ABOUT_IMAGE_PATH.QUARTO_FOLDER);
    #
    define('PHPMAILER_API_EMAIL','jose41855@gmail.com');
    define('PHPMAILER_API_PASSWORD','sqcdqbitzwkytgct');


    function AdminLogin(){
        session_start();

        if(isset($_SESSION['rol'])){
            switch($_SESSION['rol']){
            case 1:
                if ($_SESSION['verif']==0) {
                    header('location: Admin_view.php?alterar_pass');
                }else {
                    header('location: Admin_view.php');
                }
                break;
            case 2:
                if ($_SESSION['verif']==0) {
                    header('location: Recip_view.php?alterar_pass');
                }else {
                    header('location: Recip_view.php');
                }
                break;
            }
        }
    }

    function redirect($url)
    {
        echo "<script> window.location.href='$url';
        </script>";
    }


    function alert($type,$msg){
    $bg_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
                    <div class="alert $bg_class alert-dismissible fade show custom-alert" role="alert">
                        <strong class="me-3">$msg</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                alert;
    }

    function uploadImage($image, $folder) {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];
        $img_size = $image['size']/(1024*1024);
    
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img';
        } else if ($img_size > 2) {
            return 'inv_size';
        } else {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_' . rand(11111, 99999) . ".$ext";
    
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;

            if (!file_exists(UPLOAD_IMAGE_PATH.$folder)) {
                mkdir(UPLOAD_IMAGE_PATH.$folder, 0755, true);
            }
            if (move_uploaded_file($image['tmp_name'], $img_path)) {
                return $rname;
            } else {
                return 'upd_failed';
            }
        }
    }

    function deleteImage($image, $folder){
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }else{
            return false;
        }

    }

    function uploadUser_Image($image) {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];
    
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img';
        } else {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_' . rand(11111, 99999) . ".jpeg";
            $img_path = UPLOAD_IMAGE_PATH.USER_FOLDER.$rname;
    
            if($ext == 'png' || $ext == 'PNG'){
                $img = imagecreatefrompng($image['tmp_name']);
            } else if($ext == 'webp' || $ext == 'WEBP'){
                $img = imagecreatefromwebp($image['tmp_name']);
            }else{
                $img = imagecreatefromjpeg($image['tmp_name']);
            }
            if (!file_exists(UPLOAD_IMAGE_PATH.USER_FOLDER)) {
                mkdir(UPLOAD_IMAGE_PATH.USER_FOLDER, 0755, true);
            }
            
            if (imagejpeg($img,$img_path,75)) {
                return $rname;
            } else {
                return 'upd_failed';
            }
        }
    }

    function uploadSVG_Image($image, $folder){
        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type'];
        $img_size = $image['size']/(1024*1024);
    
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img';
        } else if ($img_size > 1) {
            return 'inv_size';
        } else {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_' . rand(11111, 99999) . ".$ext";
    
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;

            if (!file_exists(UPLOAD_IMAGE_PATH.ACOMADACAO_FOLDER)) {
                mkdir(UPLOAD_IMAGE_PATH.ACOMADACAO_FOLDER, 0755, true);
            }

            if (move_uploaded_file($image['tmp_name'], $img_path)) {
                return $rname;
            } else {
                return 'upd_failed';
            }
        }
    }

    function Formato_Kwanza($valor)
    {
        $ftm = new NumberFormatter("pt_AO",NumberFormatter::DECIMAL);
        $ftm ->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS,2);
        $ftm ->setPattern('#,##0.00 KZ');
        return $ftm ->format($valor);
    }

    /*function uploadUser_Image($image) {
        $valid_mime = ['image/jpeg','image/png','image/webp'];
        $img_mime = $image['type'];
    
        if (!in_array($img_mime, $valid_mime)) {
            return 'inv_img';
        } else {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_' . rand(11111, 99999) . ".jpeg";
            $img_path = UPLOAD_IMAGE_PATH.USER_FOLDER.$rname;

            if($ext == 'png' || $ext == 'PNG'){
                imagecreatefrompng($image['tmp_name']);
            } else if($ext == 'webp' || $ext == 'WEBP'){
                imagecreatefromwebp($image['tmp_name']);
            }else{imagecreatefromjpeg($image['tmp_name']);}

            if (imagejpeg($image,$img_path,75)) {
                return $rname;
            } else {
                return 'upd_failed';
            }
        }
    }*/

?>
