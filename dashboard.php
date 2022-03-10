<?php
require_once '../config/config.php';
require_once "Charts.php";
require_once header;

//	print_r(phpinfo());

//$jobQuery = $obj->query("SELECT * FROM `job` where country = '" . $_SESSION['country'] . "' ORDER BY id DESC");

$chart_params = array("sql" => "SELECT DATE(dt) AS days ,COUNT(*) AS optins FROM obd_subscriber WHERE dt BETWEEN '2016-11-09' AND '2018-01-09' GROUP BY 1");
?>

<style>
    .test-div-inner {
        padding-bottom:100%;
        background:#EEE;
        height:0;
        position:relative;
    }
    .test-image {
        width:100%;
        height:100%;
        display:block;
        position:absolute;
    }
</style>
<body ng-app="iodApp" ng-controller="iodCtrl" id="controler_id">

<div id="wrapper">

    <?php require_once nav; ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header">Dashboard</h1>

                <div class="row" ng-init="getOptinsChart()">

                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="daterange" name="daterange" autocomplete="off"
                               data-validation="required"
                               data-validation-error-msg="Title is required">

                        <input type="hidden" name="st_dt" id="st_dt"/>
                        <input type="hidden" name="end_dt" id="end_dt"/>
                    </div>

                    <div class="col-sm-2" style="margin-top: 6px">
                        <label class="radio-inline"><input type="radio" id="package_radio" name="p_radio" checked ng-click="getPromoPlanIds('package')">Package</label>
                        <label class="radio-inline"><input type="radio" id="promo_radio" name="p_radio" ng-click="getPromoPlanIds('promo')">Promo</label>
                    </div>

                    <div class="col-sm-2" style="margin-left: -2%">
                        <div class="">
                            <select id="loc_id_gb" name="location_gb" class="form-control" data-validation="required"
                                    data-validation-error-msg="Select Plan ID" ng-model="plan_drop_down" >
                                <option value="">Select Plan ID</option>
                                <option value="{{plan_id.planid}}" ng-repeat="plan_id in plan_ids">{{plan_id.name_and_id}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    <button type="button" class="btn btn-primary mybtn btn-sm" ng-click="getOptinsChart()">Apply</button>
                    </div>
                </div>

                <div id="campaign_charts" class="row">

                    <div id="loadingDiv" class="overlay">
                        <div>
                            <img src="../assets/img/loading.svg" alt="Please wait ..." class="load_img"/>
                        </div>
                    </div>

                    <!--                                                        <div class="col-sm-6">-->
<!--                                                            <div class="panel panel-default">-->
<!--                                                                <div class="panel-heading">-->
<!--                                                                    <i class="fa fa-pie-chart fa-fw"></i>-->
<!--                                                                </div>-->
<!--                                                                <div class="panel-body" id="first_graph">-->
<!--                                                                    <div class="col-sm-6">1</div>-->
<!--                                                                    <div class="col-sm-6">2</div>-->
<!--                                                                </div>-->
<!--                                                            </div>-->
<!--                                                        </div>-->


                </div>

                <br>
                <div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Optins By Date
                            <div class="pull-right">
<!--                                <div class="btn-group">-->
<!--                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle"-->
<!--                                            data-toggle="dropdown">-->
<!--                                        Actions-->
<!--                                        <span class="caret"></span>-->
<!--                                    </button>-->
<!--                                    <ul class="dropdown-menu pull-right" role="menu">-->
<!--                                        <li><a href="#">Action</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="#">Another action</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="#">Something else here</a>-->
<!--                                        </li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#">Separated link</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
                            </div>
                        </div>

                        <div class="panel-body" id="optins_by_dt">

                        </div>
                    </div>

                    <div id="main_cmp">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-table"></i> Campaign Details



                                <div class=" pull-right col-sm-2">
                                    <span class="col-sm-6"><button class="btn btn-primary btn-xs " type="button"
                                                                   csv-header="['Campaign Title ','Campaign Date','Plan ID', 'Price', 'Optins', 'Total Revenue']"
                                                                   csv-column-order="['campaign_title','optin_date', 'plan_id', 'price' ,'optins', 'revenue']"
                                                                   ng-csv="campaign_details" lazy-load="true" filename="campaign_details.csv" field-separator=','>
                                            <i class="fa fa-download"></i> CSV
                                        </button></span>
                                    <span class="col-sm-6">
                                    <select id="rec" class="form-control" style="margin-left: 50%;margin-top: -2px;height: 27px;padding: 2px 4px; !important;"
                                            ng-options='option.value as option.name for option in typeOptions' ng-model="pageSize ">
                                    </select>
                                    </span>

                                </div>
                            </div>

                            <div class="panel-body">
                                <div id="campaign_detail">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                            <tr>
                                                <th width="25%">Campaign Title</th>
                                                <th width="15%">Campaign Date</th>
                                                <th width="15%">Plan ID</th>
                                                <th width="15%">Price</th>
                                                <th width="15%">Optins</th>
                                                <th width="15%">Total Revenue</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr dir-paginate="cmp_dtls in campaign_details | itemsPerPage: pageSize">
                                                <td>{{cmp_dtls.campaign_title}}</td>
                                                <td>{{cmp_dtls.optin_date}}</td>
                                                <td>{{cmp_dtls.plan_id}}</td>
                                                <td>{{cmp_dtls.price}}</td>
                                                <td>{{cmp_dtls.optins}}</td>
                                                <td>{{cmp_dtls.revenue}}</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <dir-pagination-controls
                                                direction-links="true"
                                                boundary-links="true">
                                            </dir-pagination-controls>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <!-- /.col-lg-12 -->
            </div>

<!--            <div class="row">-->
<!--                <div class="col-lg-8">-->
<!--                    <div class="panel panel-default">-->
<!--                        <div class="panel-heading">-->
<!--                            <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example-->
<!--                            <div class="pull-right">-->
<!--                                <div class="btn-group">-->
<!--                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle"-->
<!--                                            data-toggle="dropdown">-->
<!--                                        Actions-->
<!--                                        <span class="caret"></span>-->
<!--                                    </button>-->
<!--                                    <ul class="dropdown-menu pull-right" role="menu">-->
<!--                                        <li><a href="#">Action</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="#">Another action</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="#">Something else here</a>-->
<!--                                        </li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#">Separated link</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <!-- /.panel-heading -->
<!--                        <div class="panel-body">-->
<!--                            <div id="morris-area-chart"></div>-->
<!--                        </div>-->
<!--                        <!-- /.panel-body -->
<!--                    </div>-->
<!--                    <!-- /.panel -->
<!--                    <div class="panel panel-default">-->
<!--                        <div class="panel-heading">-->
<!--                            <i class="fa fa-bar-chart-o fa-fw"></i> Bar Chart Example-->
<!--                            <div class="pull-right">-->
<!--                                <div class="btn-group">-->
<!--                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle"-->
<!--                                            data-toggle="dropdown">-->
<!--                                        Actions-->
<!--                                        <span class="caret"></span>-->
<!--                                    </button>-->
<!--                                    <ul class="dropdown-menu pull-right" role="menu">-->
<!--                                        <li><a href="#">Action</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="#">Another action</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="#">Something else here</a>-->
<!--                                        </li>-->
<!--                                        <li class="divider"></li>-->
<!--                                        <li><a href="#">Separated link</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <!-- /.panel-heading -->
<!--                        <div class="panel-body">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-4">-->
<!--                                    <div class="table-responsive">-->
<!--                                        <table class="table table-bordered table-hover table-striped">-->
<!--                                            <thead>-->
<!--                                            <tr>-->
<!--                                                <th>#</th>-->
<!--                                                <th>Date</th>-->
<!--                                                <th>Time</th>-->
<!--                                                <th>Amount</th>-->
<!--                                            </tr>-->
<!--                                            </thead>-->
<!--                                            <tbody>-->
<!--                                            <tr>-->
<!--                                                <td>3326</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>3:29 PM</td>-->
<!--                                                <td>$321.33</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3325</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>3:20 PM</td>-->
<!--                                                <td>$234.34</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3324</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>3:03 PM</td>-->
<!--                                                <td>$724.17</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3323</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>3:00 PM</td>-->
<!--                                                <td>$23.71</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3322</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>2:49 PM</td>-->
<!--                                                <td>$8345.23</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3321</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>2:23 PM</td>-->
<!--                                                <td>$245.12</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3320</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>2:15 PM</td>-->
<!--                                                <td>$5663.54</td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td>3319</td>-->
<!--                                                <td>10/21/2013</td>-->
<!--                                                <td>2:13 PM</td>-->
<!--                                                <td>$943.45</td>-->
<!--                                            </tr>-->
<!--                                            </tbody>-->
<!--                                        </table>-->
<!--                                    </div>-->
<!--                                    <!-- /.table-responsive -->
<!--                                </div>-->
<!--                                <!-- /.col-lg-4 (nested) -->
<!--                                <div class="col-lg-8">-->
<!--                                    <div id="morris-bar-chart"></div>-->
<!--                                </div>-->
<!--                                <!-- /.col-lg-8 (nested) -->
<!--                            </div>-->
<!--                            <!-- /.row -->
<!--                        </div>-->
<!--                        <!-- /.panel-body -->
<!--                    </div>-->
<!--                    <!-- /.panel -->
<!--                    <div class="panel panel-default">-->
<!--                        <div class="panel-heading">-->
<!--                            <i class="fa fa-clock-o fa-fw"></i> Responsive Timeline-->
<!--                        </div>-->
<!--                        <!-- /.panel-heading -->
<!--                        <div class="panel-body">-->
<!--                            <ul class="timeline">-->
<!--                                <li>-->
<!--                                    <div class="timeline-badge"><i class="fa fa-check"></i>-->
<!--                                    </div>-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                            <p>-->
<!--                                                <small class="text-muted"><i class="fa fa-clock-o"></i> 11-->
<!--                                                    hours ago via-->
<!--                                                    Twitter-->
<!--                                                </small>-->
<!--                                            </p>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Libero-->
<!--                                                laboriosam dolor-->
<!--                                                perspiciatis omnis exercitationem. Beatae, officia pariatur?-->
<!--                                                Est cum-->
<!--                                                veniam-->
<!--                                                excepturi. Maiores praesentium, porro voluptas suscipit-->
<!--                                                facere rem-->
<!--                                                dicta,-->
<!--                                                debitis.</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="timeline-inverted">-->
<!--                                    <div class="timeline-badge warning"><i class="fa fa-credit-card"></i>-->
<!--                                    </div>-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Autem dolorem-->
<!--                                                quibusdam, tenetur commodi provident cumque magni voluptatem-->
<!--                                                libero,-->
<!--                                                quis rerum.-->
<!--                                                Fugiat esse debitis optio, tempore. Animi officiis alias,-->
<!--                                                officia-->
<!--                                                repellendus.</p>-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Laudantium-->
<!--                                                maiores odit-->
<!--                                                qui est tempora eos, nostrum provident explicabo dignissimos-->
<!--                                                debitis-->
<!--                                                vel!-->
<!--                                                Adipisci eius voluptates, ad aut recusandae minus eaque-->
<!--                                                facere.</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="timeline-badge danger"><i class="fa fa-bomb"></i>-->
<!--                                    </div>-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Repellendus-->
<!--                                                numquam-->
<!--                                                facilis enim eaque, tenetur nam id qui vel velit similique-->
<!--                                                nihil iure-->
<!--                                                molestias-->
<!--                                                aliquam, voluptatem totam quaerat, magni commodi-->
<!--                                                quisquam.</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="timeline-inverted">-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Voluptates est-->
<!--                                                quaerat-->
<!--                                                asperiores sapiente, eligendi, nihil. Itaque quos, alias-->
<!--                                                sapiente rerum-->
<!--                                                quas-->
<!--                                                odit! Aperiam officiis quidem delectus libero, omnis ut-->
<!--                                                debitis!</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="timeline-badge info"><i class="fa fa-save"></i>-->
<!--                                    </div>-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Nobis minus-->
<!--                                                modi quam-->
<!--                                                ipsum alias at est molestiae excepturi delectus nesciunt,-->
<!--                                                quibusdam-->
<!--                                                debitis-->
<!--                                                amet, beatae consequuntur impedit nulla qui! Laborum,-->
<!--                                                atque.</p>-->
<!--                                            <hr>-->
<!--                                            <div class="btn-group">-->
<!--                                                <button type="button"-->
<!--                                                        class="btn btn-primary btn-sm dropdown-toggle"-->
<!--                                                        data-toggle="dropdown">-->
<!--                                                    <i class="fa fa-gear"></i> <span class="caret"></span>-->
<!--                                                </button>-->
<!--                                                <ul class="dropdown-menu" role="menu">-->
<!--                                                    <li><a href="#">Action</a>-->
<!--                                                    </li>-->
<!--                                                    <li><a href="#">Another action</a>-->
<!--                                                    </li>-->
<!--                                                    <li><a href="#">Something else here</a>-->
<!--                                                    </li>-->
<!--                                                    <li class="divider"></li>-->
<!--                                                    <li><a href="#">Separated link</a>-->
<!--                                                    </li>-->
<!--                                                </ul>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Sequi fuga odio-->
<!--                                                quibusdam. Iure expedita, incidunt unde quis nam! Quod,-->
<!--                                                quisquam.-->
<!--                                                Officia quam-->
<!--                                                qui adipisci quas consequuntur nostrum sequi. Consequuntur,-->
<!--                                                commodi.</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="timeline-inverted">-->
<!--                                    <div class="timeline-badge success"><i class="fa fa-graduation-cap"></i>-->
<!--                                    </div>-->
<!--                                    <div class="timeline-panel">-->
<!--                                        <div class="timeline-heading">-->
<!--                                            <h4 class="timeline-title">Lorem ipsum dolor</h4>-->
<!--                                        </div>-->
<!--                                        <div class="timeline-body">-->
<!--                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
<!--                                                Deserunt-->
<!--                                                obcaecati,-->
<!--                                                quaerat tempore officia voluptas debitis consectetur culpa-->
<!--                                                amet,-->
<!--                                                accusamus-->
<!--                                                dolorum fugiat, animi dicta aperiam, enim incidunt quisquam-->
<!--                                                maxime neque-->
<!--                                                eaque.</p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <!-- /.panel-body -->
<!--                    </div>-->
<!--                    <!-- /.panel -->
<!--                </div>-->
<!--                <!-- /.col-lg-8 -->
<!--                <div class="col-lg-4">-->
<!--                    <div class="panel panel-default">-->
<!--                        <div class="panel-heading">-->
<!--                            <i class="fa fa-bell fa-fw"></i> Notifications Panel-->
<!--                        </div>-->
<!--                        <!-- /.panel-heading -->
<!--                        <div class="panel-body">-->
<!--                            <div class="list-group">-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-comment fa-fw"></i> New Comment-->
<!--                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers-->
<!--                                    <span class="pull-right text-muted small"><em>12 minutes ago</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-envelope fa-fw"></i> Message Sent-->
<!--                                    <span class="pull-right text-muted small"><em>27 minutes ago</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-tasks fa-fw"></i> New Task-->
<!--                                    <span class="pull-right text-muted small"><em>43 minutes ago</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted-->
<!--                                    <span class="pull-right text-muted small"><em>11:32 AM</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-bolt fa-fw"></i> Server Crashed!-->
<!--                                    <span class="pull-right text-muted small"><em>11:13 AM</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-warning fa-fw"></i> Server Not Responding-->
<!--                                    <span class="pull-right text-muted small"><em>10:57 AM</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed-->
<!--                                    <span class="pull-right text-muted small"><em>9:49 AM</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="list-group-item">-->
<!--                                    <i class="fa fa-money fa-fw"></i> Payment Received-->
<!--                                    <span class="pull-right text-muted small"><em>Yesterday</em>-->
<!--                                    </span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <!-- /.list-group -->
<!--                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
<!--                        </div>-->
<!--                        <!-- /.panel-body -->
<!--                    </div>-->
<!--                    <!-- /.panel -->
<!--                    <div class="panel panel-default">-->
<!--                        <div class="panel-heading">-->
<!--                            <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example-->
<!--                        </div>-->
<!--                        <div class="panel-body">-->
<!--                            <div id="morris-donut-chart"></div>-->
<!--                            <a href="#" class="btn btn-default btn-block">View Details</a>-->
<!--                        </div>-->
<!--                        <!-- /.panel-body -->
<!--                    </div>-->
<!--                    <!-- /.panel -->
<!--                    <div class="chat-panel panel panel-default">-->
<!--                        <div class="panel-heading">-->
<!--                            <i class="fa fa-comments fa-fw"></i> Chat-->
<!--                            <div class="btn-group pull-right">-->
<!--                                <button type="button" class="btn btn-default btn-xs dropdown-toggle"-->
<!--                                        data-toggle="dropdown">-->
<!--                                    <i class="fa fa-chevron-down"></i>-->
<!--                                </button>-->
<!--                                <ul class="dropdown-menu slidedown">-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-refresh fa-fw"></i> Refresh-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-check-circle fa-fw"></i> Available-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-times fa-fw"></i> Busy-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-clock-o fa-fw"></i> Away-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="divider"></li>-->
<!--                                    <li>-->
<!--                                        <a href="#">-->
<!--                                            <i class="fa fa-sign-out fa-fw"></i> Sign Out-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <!-- /.panel-heading -->
<!--                        <div class="panel-body">-->
<!--                            <ul class="chat">-->
<!--                                <li class="left clearfix">-->
<!--                                    <span class="chat-img pull-left">-->
<!--                                        <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"-->
<!--                                             class="img-circle"/>-->
<!--                                    </span>-->
<!--                                    <div class="chat-body clearfix">-->
<!--                                        <div class="header">-->
<!--                                            <strong class="primary-font">Jack Sparrow</strong>-->
<!--                                            <small class="pull-right text-muted">-->
<!--                                                <i class="fa fa-clock-o fa-fw"></i> 12 mins ago-->
<!--                                            </small>-->
<!--                                        </div>-->
<!--                                        <p>-->
<!--                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                                            Curabitur bibendum-->
<!--                                            ornare-->
<!--                                            dolor, quis ullamcorper ligula sodales.-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="right clearfix">-->
<!--                                    <span class="chat-img pull-right">-->
<!--                                        <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar"-->
<!--                                             class="img-circle"/>-->
<!--                                    </span>-->
<!--                                    <div class="chat-body clearfix">-->
<!--                                        <div class="header">-->
<!--                                            <small class=" text-muted">-->
<!--                                                <i class="fa fa-clock-o fa-fw"></i> 13 mins ago-->
<!--                                            </small>-->
<!--                                            <strong class="pull-right primary-font">Bhaumik Patel</strong>-->
<!--                                        </div>-->
<!--                                        <p>-->
<!--                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                                            Curabitur bibendum-->
<!--                                            ornare-->
<!--                                            dolor, quis ullamcorper ligula sodales.-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="left clearfix">-->
<!--                                    <span class="chat-img pull-left">-->
<!--                                        <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"-->
<!--                                             class="img-circle"/>-->
<!--                                    </span>-->
<!--                                    <div class="chat-body clearfix">-->
<!--                                        <div class="header">-->
<!--                                            <strong class="primary-font">Jack Sparrow</strong>-->
<!--                                            <small class="pull-right text-muted">-->
<!--                                                <i class="fa fa-clock-o fa-fw"></i> 14 mins ago-->
<!--                                            </small>-->
<!--                                        </div>-->
<!--                                        <p>-->
<!--                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                                            Curabitur bibendum-->
<!--                                            ornare-->
<!--                                            dolor, quis ullamcorper ligula sodales.-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="right clearfix">-->
<!--                                    <span class="chat-img pull-right">-->
<!--                                        <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar"-->
<!--                                             class="img-circle"/>-->
<!--                                    </span>-->
<!--                                    <div class="chat-body clearfix">-->
<!--                                        <div class="header">-->
<!--                                            <small class=" text-muted">-->
<!--                                                <i class="fa fa-clock-o fa-fw"></i> 15 mins ago-->
<!--                                            </small>-->
<!--                                            <strong class="pull-right primary-font">Bhaumik Patel</strong>-->
<!--                                        </div>-->
<!--                                        <p>-->
<!--                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                                            Curabitur bibendum-->
<!--                                            ornare-->
<!--                                            dolor, quis ullamcorper ligula sodales.-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <!-- /.panel-body -->
<!--                        <div class="panel-footer">-->
<!--                            <div class="input-group">-->
<!--                                <input id="btn-input" type="text" class="form-control input-sm"-->
<!--                                       placeholder="Type your message here..."/>-->
<!--                                <span class="input-group-btn">-->
<!--                                    <button class="btn btn-warning btn-sm" id="btn-chat">-->
<!--                                        Send-->
<!--                                    </button>-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <!-- /.panel-footer -->
<!--                    </div>-->
<!--                    <!-- /.panel .chat-panel -->
<!--                </div>-->
<!--                <!-- /.col-lg-4 -->
<!--            </div>-->
            <!-- /.row -->
            <!-- /.row -->
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>


    <script>

        var date = new Date();
        var yesterday = date - 1000 * 60 * 60 * 24 * 30;
        var dt = new Date(yesterday);

        $('input[name="daterange"]').daterangepicker(
            {
                locale               : {
                    format: 'YYYY-MM-DD'
                },
                startDate: dt,
                "alwaysShowCalendars": true,
                "timePicker"         : true
            },
            function (start, end, label) {

                $("#st_dt").val(start.format('YYYY-MM-DD HH:mm:ss'));
                $("#end_dt").val(end.format('YYYY-MM-DD HH:mm:ss'));

            });

        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {

            //$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

            var scope = angular.element("#controler_id").scope();
            scope.getOptinsChart();
            //scope.getCampaignDetails();
        });

    </script>

</body>

</html>
