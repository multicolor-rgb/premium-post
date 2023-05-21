<?php




class premiumPost extends Plugin
{

    public function siteHead()
    {
        echo '<link rel="stylesheet" href="' . $this->domainPath() . 'css/premiumpost.css"/>';
    }



    public function adminBodyEnd()
    {

        global $page;

        $folder = PATH_CONTENT.'premiumPost/';

        if(file_exists($folder)==false){
          mkdir($folder,0755);
          file_put_contents($folder.'.htaccess','Deny from all');
        };


        if ($page !== false) {
            echo '<script src="' . $this->domainPath() . 'js/addinput.js"></script>';

            $filec = $folder . $page->title();
            echo $filec;
            $encoded = base64_decode(@file_get_contents($filec));
            echo '<script> document.querySelector(".premiumpassword").value = `' . $encoded . '` </script>';
        };
    }

    public function afterPageModify()
    {


        if (isset($_POST['password-premium'])) {

            $pass = base64_encode($_POST['password-premium']);
            $folder = PATH_CONTENT.'premiumPost/';
            $filename = $folder . $_POST['title'];
            $chmod_mode    = 0755;
            $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

            if ($folder_exists) {
                file_put_contents($filename, $pass);
            }
        }
    }




    public function form(){

        echo '

        <h4>How to use it?</h4>

        <br>

        <p>Replace</p>

        <code style="display:block;width:100%;padding:10px;box-sizing:border-box;">
        &#60;?php  echo $page->content() ;?&#62;
        </code>
        <br>
        <p>to</p>
        <code style="display:block;width:100%;padding:10px;box-sizing:border-box;">
        &#60;?php get_passContent() ;?&#62;
        </code>

        ';

    }
}



function get_passContent()
{

    global $page;
    global $L;
    $folder = PATH_CONTENT.'premiumPost/';


    $filec = $folder . $page->title();


    $encoded = base64_decode(@file_get_contents(@$filec));

    if ($encoded !== '') {


        if (isset($_POST['passcontent'])) {


            if ($_POST['passcontent'] == $encoded) {
                echo $page->content();
            } else {
                echo '<div class="premiumpost_error">'.$L->get('bad-password').'</div>';
            }
        } else {
            echo '<form action="" method="post" class="premiumpost">
        <label>'.$L->get('enter-the-password').'</label><br>
        <input type="password" name="passcontent">
<input type="submit" value="'.$L->get('get-access').'">
        </form>';
        }
    } else {

        echo $page->content();
    }
}
