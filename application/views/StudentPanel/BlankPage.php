<?php
defined("BASEPATH") or exit("No direct scripts allowed here");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("HeaderLinking.php"); ?>
</head>

<body>

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">

        <?php include("Sidebar.php"); ?>

        <?php include("Topbar.php"); ?>

        <div class="clearfix"></div>

        <div class="content-wrapper">
            <div class="container-fluid">

                <!-- Breadcrumb-->
                <div class="row pt-2 pb-2">
                    <div class="col-sm-9">
                        <h4 class="page-title"> Page Title</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javaScript:void();">CodersAdda Student</a></li>
                            <li class="breadcrumb-item"><a href="javaScript:void();">Page</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
                        </ol>
                    </div>
                    <div class="col-sm-3">
                       
                       
                    </div>
                </div>
                <!-- End Breadcrumb-->



                <!--End Dashboard Content-->

                <!--start overlay-->
                <div class="overlay toggle-menu"></div>
                <!--end overlay-->

            </div>
            <!-- End container-fluid-->

        </div>
        <!--End content-wrapper-->

        <?php include("Footer.php"); ?>


    </div>
    <!--End wrapper-->

    <?php
    include("FooterLinking.php");
    ?>

    <script>
    $(function() {
        $(".knob").knob();
    });
    </script>
    <!-- Index js -->
    <script src="<?php base_url("assets_panel/js/index.js"); ?>"></script>


</body>

</html>