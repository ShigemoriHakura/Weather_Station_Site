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
                            <?=_L('Token_Index')?></h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><?=_L('Token_Title')?></h5>
                            <span><?=_L('Token_Desc3')?>
                                <? if (!$PRM['status']) {?>
                                <code class="text-danger"><?=_L('Token_Failed')?></code> </span>
                            <?}else{ ?>
                                <code class="text-success"><?=_L('Token_Success')?></code> </span>
                            <?} ?>
                            <span><?=_L('Token_Desc')?> <code class="text-danger"><?=_L('Token_Desc2')?></code> </span>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate="" action="<?=$webRoot?>/add" method="post">
                                <div class="form-row">
                                    <input type="text" name="_csrf" hidden value="<?=$this->getCsrfToken()?>"/>
                                    <div class="col-md-12 mb-12">
                                        <label for="validationCustom01"><?=_L('Token_Note')?></label>
                                        <input name="note" class="form-control" id="validationCustom01" type="text" placeholder="<?=_L('Token_Note')?>" required="" autocomplete="off">
                                        <div class="valid-feedback"><?=_L('Token_CheckOK')?></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-12 mb-12">
                                        <label for="validationCustom05"><?=_L('Token_City')?></label>
                                        <input name="city" class="form-control" id="validationCustom05" type="text" placeholder="<?=_L('Token_City')?>" required="" autocomplete="off">
                                        <div class="valid-feedback"><?=_L('Token_CheckOK')?></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="form-check">
                                        <div class="checkbox p-0">
                                            <input class="form-check-input" id="invalidCheck" type="checkbox" required="">
                                            <label class="form-check-label" for="invalidCheck"><?=_L('Token_CheckedOK')?></label>
                                        </div>
                                        <div class="invalid-feedback"><?=_L('Token_NotCheckedOK')?></div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit"><?=_L('Token_Submit')?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>