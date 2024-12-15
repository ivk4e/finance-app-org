<?php 

?>

<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <section class="position-relative py-4 py-xl-5">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-5">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <form class="text-center" method="post" action="handlers/handlers_shared/handler_add_group.php">
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;margin-top: 16px;">Наименование на група</label><input class="form-control" type="text" name="group_name" style="text-align: left;"></div>
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Участник</label><input class="form-control" type="text" name="member_email" style="text-align: left;"></div>
                                            <div class="mb-3"><label class="form-label d-xxl-flex" style="width: 207px;margin-bottom: 1px;font-size: 14px;text-align: left;">Предназначение на групата</label><input class="form-control" type="text" name="purpose" style="text-align: left;"></div>
                                            <div class="mb-3"><button class="btn btn-success d-block w-100" type="submit">Запази</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>