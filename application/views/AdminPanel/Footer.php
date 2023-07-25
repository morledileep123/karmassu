 <?php
    defined("BASEPATH") or exit("No direct scripts allowed here");
    ?> 
 <!--Start Back To Top Button-->
 <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
 <!--End Back To Top Button-->

 <!--Start footer-->
 <footer class="footer">
     <div class="container">
         <div class="text-center">
             Copyright © <?= date('Y'); ?> To <a href="<?=$this->data->appLink;?>"><?=$this->data->appName;?></a>. All Rights Reserved || Developed By <a href="<?=$this->data->copyrightLink;?>"><?=$this->data->copyrightName;?></a>
         </div>
     </div>
 </footer>
 <!--End footer-->