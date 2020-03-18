<?php
$page_title = 'Word Cloud';
include 'header.php';?>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Word Cloud</h1>
<!--                    <div class="btn-toolbar mb-2 mb-md-0">-->
<!--                        <div class="btn-group mr-2">-->
<!--                            <button type="button" class="btn btn-sm btn-outline-secondary">All</button>-->
<!--                            <button type="button" class="btn btn-sm btn-outline-secondary">Hong Kong</button>-->
<!--                            <button type="button" class="btn btn-sm btn-outline-secondary">Singapore</button>-->
<!--                        </div>-->
<!--                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">-->
<!--                            <span data-feather="calendar"></span>-->
<!--                            This week-->
<!--                        </button>-->
<!--                    </div>-->
                </div>
            </main>
            <div class="row col-md-12">
                <div class="col-md-4">
                </div>
                <div class="col-md-4" style="margin-top:30px;">
<!--                    <h5 class="h5 text-center">WordCloud</h5>-->
                    <img src="wc-overall.png" class="img-fluid rounded float-center" >
                </div>
<!--                <div class="col-md-4">-->
<!--                    <h5 class="h5 text-center">WordCloud (Positive)</h5>-->
<!--                    <img src="wc-positive.png" class="img-fluid rounded float-center" >-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <h5 class="h5 text-center">WordCloud (Negative)</h5>-->
<!--                    <img src="wc-negative.png" class="img-fluid rounded float-center" >-->
<!--                </div>-->
            </div>
        </div>

    </div>

<?php include 'footer.php';?>