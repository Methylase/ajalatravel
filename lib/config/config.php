 <?php
 if(!defined('Ajaccess')){
   die('<div style="width:98%; padding:10px;background-color:maroon; border-radius:3px; margin-top:20px"><marquee><h2 style="text-align:center; color:white"> No access contact the administrator</h2></marquee></div>');
 }


 define("dbhost","localhost");
 define("dbuser","root");
 define("dbpass","smoothless");
 define("dbname","ajalatravel");
     $db = new PDO("mysql:host=".dbhost.";dbname=".dbname, dbuser,dbpass);
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     function __autoload($class){
        $class =strtolower($class);
        $classpath = '../lib/admin/class.'.$class.'.php';
        if(file_exists($classpath)){
            require_once($classpath);
        }
     }
      $user =new User($db);
      $profile =new Profile($db);
 ?>