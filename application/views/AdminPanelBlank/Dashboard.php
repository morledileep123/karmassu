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

                <!--Start Dashboard Content-->

                <div class="row mt-3">
                    <div class="col-12 col-lg-6 col-xl-3">
                        <div class="card gradient-deepblue">
                            <div class="card-body">
                                <h5 class="text-white mb-0">9526 <span class="float-right"><i
                                            class="fa fa-shopping-cart"></i></span></h5>
                                <div class="progress my-3" style="height:3px;">
                                    <div class="progress-bar" style="width:100%"></div>
                                </div>
                                <p class="mb-0 text-white small-font">Total Orders </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3">
                        <div class="card gradient-orange">
                            <div class="card-body">
                                <h5 class="text-white mb-0">8323 <span class="float-right"><i
                                            class="fa fa-usd"></i></span></h5>
                                <div class="progress my-3" style="height:3px;">
                                    <div class="progress-bar" style="width:100%"></div>
                                </div>
                                <p class="mb-0 text-white small-font">Total Revenue</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3">
                        <div class="card gradient-ohhappiness">
                            <div class="card-body">
                                <h5 class="text-white mb-0">6200 <span class="float-right"><i
                                            class="fa fa-eye"></i></span></h5>
                                <div class="progress my-3" style="height:3px;">
                                    <div class="progress-bar" style="width:100%"></div>
                                </div>
                                <p class="mb-0 text-white small-font">Visitors </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-3">
                        <div class="card gradient-ibiza">
                            <div class="card-body">
                                <h5 class="text-white mb-0">5630 <span class="float-right"><i
                                            class="fa fa-envira"></i></span></h5>
                                <div class="progress my-3" style="height:3px;">
                                    <div class="progress-bar" style="width:100%"></div>
                                </div>
                                <p class="mb-0 text-white small-font">Messages</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Row-->



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