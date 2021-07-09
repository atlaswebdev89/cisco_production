<header id="header-slogan-modal-2" class="pt-100 pb-200 light">
    <div class="container-fluid">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button" style="padding: 5px; margin-right: 15px; margin-left: 15px;">
                <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0">
                    <strong>Access Point</strong> Maps
                </h2>
                <div class="col-md-4 col-xs-12 text-center col-md-offset-4" style="margin-bottom: 10px;">
                    <label for="points" class="dark">Группы точек</label>
                    <select  name="points" id="points" class="form-control"></select>
                    <button id = "allPoint" class="btn-success btn btn-sm navbar-btn">
                        <span style="">Все точки</span>
                    </button>
                </div>

                <div class="clearfix"></div>
                <div id="map"></div>
            </div>
        </div>
    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
    <script>
        var dataPoint = {{data | raw }};
        var longitude = {{longitude}};
        var latitude = {{latitude}};
        var zoom = {{zoom}};
        var idGroupRequest = '{{id_bussiness}}';
    </script>
</header>

