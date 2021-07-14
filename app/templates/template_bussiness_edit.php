<header id="header-slogan-modal-2" class="pt-200 pb-250 light">
    <div class="container">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button">
                <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                <p class="compressed-box-50 mb-100 dark text-center" style="">
                    Редактор организации<br>
                </p>
                <form class="compressed-box-50 m-auto point-redactor text-center dark"  method="">
                    <input class="btn-info btn text-center" type="button" onclick="history.back();" value="Назад"/><br />
                    {%for point in data %}
                        <div class="form-group">
                            <div class ="input-group col-md-12">
                                <label for="name" style="font-weight:inherit !important;">Название организации</label>
                                <input id = "name"  value ="{{point.name}}" type="text" class="form-control" placeholder="название организации" name="name"  required>
                            </div>
                        </div>

                    <div class="form-group">
                        <div class ="input-group col-md-12">
                            <label for="description" style="font-weight:inherit !important;">Описание организации</label>
                            <input class="form-control" type="text" id="description" name="description"  value="{{point.description}}" placeholder="описание организации" />
                        </div>
                    </div>

                    <div class="form-group">
                            <div class ="input-group col-md-12">
                                <label for="color" style="font-weight:inherit !important;">Цвет метки на карте</label>
                                <input class="form-control jscolor {hash:true}" type="text" id="color" name="color" value ="{{point.placemark_color}}" placeholder="цвет метки на карте" />
                            </div>
                    </div>


                    <input type="button" name="button-edit-bussiness" data-id-bussiness = "{{point.id}}" value ="изменить" class="btn btn-block btn-success " id="button-edit-bussiness">
                        <div class="form-group response_order">
                            <p style="text-align: center; display: none;"></p>
                        </div>
                    {%endfor%}

                </form>

            </div>
        </div>
    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
</header>


