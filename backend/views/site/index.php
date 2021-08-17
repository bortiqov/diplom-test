<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <!-- Start col -->
    <div class="col-md-12 col-lg-12 col-xl-7">
        <div class="card m-b-30">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-7">
                        <h5 class="card-title mb-0">Audience</h5>
                    </div>
                    <div class="col-5">
                        <ul class="list-inline-group text-right mb-0 pl-0">
                            <li class="list-inline-item mr-0 font-12">Update <a href="#"><i class="feather icon-refresh-cw font-16 text-primary ml-1"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="analytic-chart-label pb-3 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <p class="mb-2">Amount</p>
                            <h3><sup>$</sup>56</h3>
                        </div>
                        <div class="col-md-6">
                            <p class="analytic-label-perform">*Shopping Campaign has performed 47% better.</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-2"><i class="feather icon-circle text-primary mr-2"></i>Selling</p>
                            <p class="mb-0"><i class="feather icon-circle text-warning mr-2"></i>Likes</p>
                        </div>
                    </div>
                </div>
                <div id="morris-area-without-smooth" class="morris-chart"></div>
            </div>
        </div>
    </div>
    <!-- End col -->
    <!-- Start col -->
    <div class="col-md-12 col-lg-12 col-xl-5">
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Total Visits</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p class="dash-analytic-icon"><i class="feather icon-eye primary-rgba text-primary"></i></p>
                                <h3 class="mb-3"><?=$stats[1]['count']?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">New Users</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p class="dash-analytic-icon"><i class="feather icon-users warning-rgba text-warning"></i></p>
                                <h3 class="mb-3"><?=$newUsers?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="card-title mb-0">Popular organizations</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dash-flag-icon">
                            <table class="table table-borderless mb-2">
                                <thead>
                                <tr>
                                    <th scope="col">Sr.No</th>
                                    <th scope="col">Organization</th>
                                    <th scope="col">Views</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($popularOrganizations as $index => $organization): ?>
                                <tr>
                                    <th scope="row"><?=$index+1?></th>
                                    <td><a href="<?= getenv( 'FRONTEND_URL' ) . \Yii::$app->urlManager->createUrl(['organization/view', 'id' => $organization->id])?>"><?=$organization->getPrettyName()?></a></td>
                                    <td><?=$organization->viewed?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
    <!-- Start col -->
    <div class="col-md-12 col-lg-6 col-xl-4">
        <div class="card m-b-30">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title mb-0">Top Keywords</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive dash-flag-icon">
                    <table class="table table-borderless mb-2">
                        <thead>
                        <tr>
                            <th scope="col">Sr.No</th>
                            <th scope="col">Keyword</th>
                            <th scope="col">Clicks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>latest</td>
                            <td>41</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>featured</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>trending</td>
                            <td>14</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>popular</td>
                            <td>9</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>new</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>fashion</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>ecommerce</td>
                            <td>2</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
    <!-- Start col -->
    <div class="col-md-12 col-lg-12 col-xl-4">
        <div class="card m-b-30">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title mb-0">Sessions</h5>
                    </div>
                    <div class="col-4">
                        <ul class="list-inline-group text-right mb-0 pl-0">
                            <li class="list-inline-item mr-0 font-12"><button type="button" class="btn btn-sm btn-primary-rgba font-14 px-2">Export</button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-label">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <p><i class="feather icon-square text-primary"></i>Mobile</p>
                        </li>
                        <li class="list-inline-item">
                            <p><i class="feather icon-square text-warning"></i>Desktop</p>
                        </li>
                    </ul>
                </div>
                <div id="morris-donut" class="morris-chart" data-desktop="<?=$stats[1]['count'] - $stats[0]['count']?>" data-mobile="<?=$stats[0]['count']?>"></div>
            </div>
        </div>
    </div>
    <!-- End col -->
    <!-- Start col -->
    <div class="col-md-12 col-lg-12 col-xl-4">
        <div class="card m-b-30">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="card-title mb-0">Activities</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="activities-history">
                    <div class="activities-history-list activities-primary">
                        <i class="feather icon-code"></i>
                        <div class="activities-history-item">
                            <h6>Balance is running low. <span class="text-muted font-12 float-right">Today, 09:39 PM</span></h6>
                            <p class="mb-0">We suggest you to recharge your ad balance via online payment until 28-03-2019 at 4:00 pm</p>
                        </div>
                    </div>
                    <div class="activities-history-list activities-success">
                        <i class="feather icon-layers"></i>
                        <div class="activities-history-item">
                            <h6>Mark Joe increased Ad-01. <span class="text-muted font-12 float-right">Yesterday, 02:25 AM</span></h6>
                            <p class="mb-0">Ad-01 spending per day has been increased to $25 from $20 to reach out to more people.</p>
                        </div>
                    </div>
                    <div class="activities-history-list activities-danger">
                        <i class="feather icon-folder"></i>
                        <div class="activities-history-item">
                            <h6>Renessa started new Ad set. <span class="text-muted font-12 float-right">24-Feb, 01:10 PM</span></h6>
                            <p class="mb-0">She atarted a new Ad set on various marketing plateform.</p>
                        </div>
                    </div>
                    <div class="activities-history-list activities-info">
                        <i class="feather icon-credit-card"></i>
                        <div class="activities-history-item">
                            <h6>Get summary report. <span class="text-muted font-12 float-right">20-Feb, 05: 45 PM</span></h6>
                            <p class="mb-0">Get summary report for last annual year from the manager. It will be represent on annual board meeting at chicago.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>
