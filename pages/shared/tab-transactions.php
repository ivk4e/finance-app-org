<?php 

?>

<p><em><span style="color: rgb(106, 106, 106);">Тук може да проследиш история на транзакциите.</span></em></p>
<div class="d-xxl-flex justify-content-xxl-end" style="margin-bottom: 20px;"><a href="?page=shared-finances&action=addTransaction" style="text-decoration: none;"><button class="btn btn-success d-xxl-flex justify-content-xxl-center" type="button" style="color: var(--bs-btn-color);padding-right: 12px;--bs-success: #198754;--bs-success-rgb: 25,135,84;"><i class="material-icons d-xxl-flex justify-content-xxl-end" style="margin-right: 10px;font-size: 24px;">add</i>Добави транзакция</button></a><button class="btn btn-primary d-xxl-flex" type="button" style="background: rgba(33,37,41,0);border-style: none;"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" style="color: var(--bs-link-color);border-style: none;font-size: 24px;">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path>
        </svg></button></div>
<div class="d-inline-flex filters-fields">
    <div class="filters-text-input"><label class="form-label d-flex"><strong>Дата на транзакция:</strong></label><input type="date"></div>
    <div class="filters-text-input"><label class="form-label d-flex"><strong>Email:</strong></label><input class="d-flex" type="text"></div>
</div>
<div class="d-xxl-flex justify-content-xxl-start" style="margin-bottom: 20px;"><button class="btn btn-primary d-xxl-flex justify-content-xxl-center" type="button" style="color: var(--bs-btn-color);background: var(--bs-link-color);border-color: var(--bs-link-color);padding-right: 12px;"><i class="material-icons d-xxl-flex justify-content-xxl-end" style="margin-right: 10px;font-size: 24px;">filter_list</i>Филтрирай</button><button class="btn btn-primary d-xxl-flex" type="button" style="background: rgba(33,37,41,0);border-style: none;"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" style="color: var(--bs-link-color);border-style: none;font-size: 24px;">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path>
        </svg></button></div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Дата на транзакция</th>
                <th>Име на потребител</th>
                <th>Email</th>
                <th>Име на група</th>
                <th>Цел</th>
                <th>Сума</th>
                <th>Опции</th>
            </tr>
        </thead>
        <tbody>
        
        </tbody>
    </table>
</div>