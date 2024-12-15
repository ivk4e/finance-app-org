<?php
    
?>
<div id="sidebar">
            <div class="offcanvas offcanvas-start bg-body" tabindex="-1" id="offcanvas-menu" style="width: 275px;background: rgb(112,112,112);">
                <div class="offcanvas-header" style="background:rgba(242,242,242,0.5);"><a class="link-body-emphasis d-flex align-items-center me-md-auto mb-3 mb-md-0 text-decoration-none"><svg class="me-3" xmlns="http://www.w3.org/2000/svg" height="1em" viewbox="0 0 24 24" width="1em" fill="currentColor" style="font-size:25px;"><rect fill="none" height="24" width="24"></rect><rect height="2" width="18" x="3" y="3"></rect><rect height="2" width="18" x="3" y="19"></rect><rect height="2" width="18" x="3" y="11"></rect></svg><span class="fs-4">Навигация</span></a><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="offcanvas"></button></div>
                <div class="offcanvas-body d-flex flex-column justify-content-between pt-0" style="background:#f2f2f280;">
                    <div>
                        <hr class="mt-0">
                        <ul class="nav nav-pills flex-column mb-auto">
                            <li class="nav-item"><a class="nav-link <?php echo($page == 'hello' ? 'active' : '') ?> link-body-emphasis" aria-current="page" href="?"><svg class="bi bi-speedometer2 me-2" fill="currentColor" height="1em" viewbox="0 0 16 16" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"></path><path d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3" fill-rule="evenodd"></path></svg><span>&nbsp;Табло за управление</span></a></li>
                            <li class="nav-item"><a class="nav-link <?php echo($page == 'finance-goals' ? 'active' : '') ?> link-body-emphasis" href="?page=finance-goals"><svg class="bi bi-cash-coin me-2" fill="currentColor" height="1em" viewbox="0 0 16 16" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" fill-rule="evenodd"></path><path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"></path><path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"></path><path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"></path></svg>&nbsp;Финансови цели</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo($page == 'my-credits' ? 'active' : '') ?> link-body-emphasis" href="?page=my-credits"><svg class="bi bi-credit-card me-2" fill="currentColor" height="1em" viewbox="0 0 16 16" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"></path><path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"></path></svg>&nbsp;Финансови задължения</a>
                            <a class="nav-link <?php echo($page == 'shared-finances' ? 'active' : '') ?> link-body-emphasis" href="?page=shared-finances&tab=groups"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
</svg>&nbsp; Споделени финанси</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo($page == 'profile-settings' ? 'active' : '') ?> link-body-emphasis" href="?page=profile-settings"><svg class="bi bi-person-gear me-2" fill="currentColor" height="1em" viewbox="0 0 16 16" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"></path></svg> Настройки</a></li>
                        </ul>
                    </div>
                    <div>
                        <a href="/finance-app/pages/logout.php" style="text-decoration: none;">
                            <hr><button class="btn btn-danger" id="exit-btn" type="button" style="width: 242px;">Изход</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>