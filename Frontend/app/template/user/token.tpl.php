<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>
<?php include App::$view_root . "/base/sideBar.tpl.php" ?>

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=$webRoot?>"><i class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                    <h3>
                        <?=_L('Index_Index')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-with-border tickets">
                    <div class="card-header card-no-border">
                        <div class="d-flex">
                            <h5><?=_L('Token_Title')?></h5>
                            <a target="_blank" href="<?=$webRoot?>/add">
                            <button class="btn btn-outline-light" type="button">+</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive agent-performance-table">
                            <table class="table table-bordernone">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block"><span class="f-12 f-w-600"><?=_L('Token_Token')?></span></span></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Token_ID')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Token_Note')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Token_City')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Token_Action')?></p>
                                        </td>
                                    </tr>
                                    <? if ($PRM['tokenData']->count() > 0){?>
                                        <? $rankI = 0?>
                                        <? foreach ($PRM['tokenData'] as $k => $v){?>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <span class="f-12 f-w-600"><?=$v['token']?></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="f-w-600"><?=$v['id']?></p>
                                                    </td>
                                                    <td>
                                                        <p class="f-w-600"><?=$v['note']?></p>
                                                    </td>
                                                    <td>
                                                        <p class="f-w-600"><?=$v['city']?></p>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="/t/<?=$v['id']?>"><button class="btn btn-primary btn-square digits"><?=_L('Token_Detail')?></button></a>
                                                    </td>
                                                </tr>
                                        <? }?>
                                    <? }else{ ?>
                                        <tr>
                                            <td>
                                                /
                                            </td>
                                            <td>
                                                <p class="f-w-600"><?=_L('Token_NoResult')?></p>
                                            </td>
                                            <td>
                                                /
                                            </td>
                                            <td>
                                                /
                                            </td>
                                            <td>
                                                /
                                            </td>
                                        </tr>
                                    <? }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>


<script>
    /*var SweetAlert_custom = {
        init: function() {
            document.querySelector('.sweet-add').onclick = function(){
                swal("Write something here:", {
                    content: "input",
                })
                .then((value) => {
                    swal(`You typed: ${value}`);
                });
            };
        }
    };
    (function($) {
        SweetAlert_custom.init()
    })(jQuery);*/
</script>