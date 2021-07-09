<header id="header-slogan-modal-2" class="pt-200 pb-250 light">
    <div class="container">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button">
                <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                <p class="compressed-box-50 mb-100 dark text-center" style="">
                    Редактор точки доступа<br>
                </p>


                    <form class="compressed-box-50 m-auto point-redactor text-center" method="POST">
                        {%for point in point_data %}

                        <div class="form-group">
                            <div class ="input-group col-md-12">
                                <label for="ip">Ip точки</label>
                                <input id = "ip" value ="{{point.ip}}" type="text" class="form-control" placeholder="ip адрес точки" name="ip"   required>
                            </div>
                        </div>
                        <div class="form-group col-md-6 my-class-padding">
                            <label>Название организации</label>
                            <select id = "form-point-add" class="form-control" name = "busines" required>
                                <option></option>
                                    {%for data in business%}
                                        {% if data.name == point.name %}
                                                <option selected="selected" value="{{data.id}}">{{data.name}}</option>
                                        {% else  %}
                                                <option value="{{data.id}}">{{data.name}}</option>
                                        {% endif %}
                                    {%endfor%}
                            </select>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <label>Название сети</label>
                            <select id = "ssid-add" class="form-control" name = "ssid" required>
                                <option></option>
                                {%for data in ssid%}
                                    {% if data.ssid == point.ssid %}
                                        <option selected="selected"  value="{{data.id}}">{{data.ssid}}</option>
                                    {% else  %}
                                        <option   value="{{data.id}}">{{data.ssid}}</option>
                                    {% endif %}
                                {%endfor%}
                            </select>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <label>Тип точки</label>
                            <select class="form-control" title="Укажите тип точки" placeholder="тип точки" name = "type-point" required>
                                <option  value = '' disabled="disabled">Тип точки</option>
                                {% if point.type == 'Внутреняя' %}
                                    <option selected="selected" value = "Внутреняя">Внутреняя</option>
                                    <option value = "Внешняя">Внешняя</option>
                                {% elseif point.type == 'Внешняя' %}
                                    <option  value = "Внутреняя">Внутреняя</option>
                                    <option selected="selected" value = "Внешняя">Внешняя</option>
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <label>Оплата</label>
                            <select class="form-control" title="Укажите тип оплаты" placeholder="оплата" name = "payment" required>
                                <option value = '' disabled="disabled">Оплата</option>
                                {% if point.payment == 'free' %}
                                    <option selected="selected" value = "free">Общедоступная точка wifi</option>
                                    <option value = "pay">CiscoWifi в пользованиие</option>
                                {% elseif point.payment == 'pay' %}
                                    <option value = "free">Общедоступная точка wifi</option>
                                    <option selected="selected"  value = "pay">CiscoWifi в пользованиие</option>
                                {% else %}
                                    <option value = "pay">CiscoWifi в пользованиие</option>
                                    <option value = "free">Общедоступная точка wifi</option>
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <label>Модель точки</label>
                            <select class="my-select form-control"  name = "model-point" required>
                                <option selected="selected" value = '' disabled="disabled">Модель точки</option>
                                {%for data in models%}
                                    {% if point.model == data.model%}
                                        <option selected="selected" value="{{data.id}}">{{data.model}}</option>
                                    {% else  %}
                                        <option  value="{{data.id}}">{{data.model}}</option>
                                    {% endif %}
                                {%endfor%}
                            </select>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <div class ="input-group col-md-12">
                                <label for="mac_address">MAC адрес точки</label>
                                <input type="text" class="form-control"  value ={{point.mac}} placeholder="Mac-адрес" name="mac_address" id="mac_address">
                            </div>
                        </div>

                        <div class="form-group my-class-padding col-md-6">
                            <label for="speed_download">Входящая скорость</label>
                            <select class="form-control" name="speed_download" id = "speed_download" required>
                                <option selected="selected" value='' disabled="disabled" >Download (mbit/s)</option>
                                {%for data in speed%}
                                    {% if point.speed_download == data.speed %}
                                        <option selected="selected" value="{{data.speed}}">{{data.speed}}</option>
                                    {% else %}
                                        <option value="{{data.speed}}">{{data.speed}}</option>
                                    {% endif %}
                                {%endfor%}
                            </select>
                        </div>

                        <div class="form-group  my-class-padding col-md-6">
                            <label for="speed_upload">Исходящая скорость</label>
                            <select class="form-control" name="speed_upload" id ="speed_upload" required>
                                <option selected="selected" value='' disabled="disabled" >Upload (mbit/s)</option>
                                {%for data in speed%}
                                        {% if point.speed_upload == data.speed %}
                                            <option selected="selected" value="{{data.speed}}">{{data.speed}}</option>
                                        {% else %}
                                            <option  value="{{data.speed}}">{{data.speed}}</option>
                                        {% endif %}
                                {%endfor%}
                            </select>
                        </div>



                        <div class="form-group col-md-6 my-class-padding">
                            <div class ="input-group col-md-12">
                                <label for="date">Дата установки точки</label>
                                <input type="date" class="form-control" placeholder="Дата установки" name="date" id="date" value ="{{point.installation_date}}" required>
                            </div>
                        </div>

                        <div class="form-group  col-md-6 my-class-padding">
                            <div class ="input-group col-md-12">
                                <label for="customer">Контакты заказчика</label>
                                <input type="text" class="form-control" placeholder="Контакты заказчика" name="customer" id="customer" value="{{point.customer}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class ="input-group col-md-12">
                                <label for="suggest">Адрес установки</label>
                                <input type="text" class="form-control" name ="address" id="suggest" value = "{{point.address}}">
                            </div>
                            <button type="button" id="button-maps" >Показать на карте</button>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <div class ="input-group ">
                                <label for="latitude">Координаты, широта</label>
                                <input disabled="disabled" type="text" class="form-control" id="latitude" name = "latitude"  value = "{{point.latitude}}">
                            </div>
                        </div>
                        <div class="form-group col-md-6 my-class-padding">
                            <div class ="input-group ">
                                <label for="longitude">Координаты, долгота</label>
                                <input disabled="disabled" type="text" class="form-control" id="longitude" name ="longitude" value = "{{point.longitude}}">
                            </div>

                        </div>
                        <div class="form-group my-class-padding col-md-12">
                            <div id="map" ></div>
                        </div>

                        <div class="form-group  col-md-6 my-class-padding">
                            <div class ="input-group col-md-12">
                                <label for="set_place">Место установки</label>
                                <input type="text" class="form-control" placeholder="Место установки" name="set_place" id="set_place" value = "{{point.set_place}}">
                            </div>
                        </div>

                        <div class="form-group col-md-6 my-class-padding">
                            <label>Зона ответственности</label>
                            <select class="form-control" title="Укажите зону ответственности" placeholder="Зона ответственности" name = "responsibility" required>
                                {% if point.responsibility == 'gts' %}
                                        <option selected="selected" value = "gts">ГТС</option>
                                        <option value = "sts">CTC</option>
                                {% elseif point.responsibility == 'sts' %}
                                        <option value = "gts">ГТС</option>
                                        <option selected="selected"  value = "sts">CTC</option>
                                {% else %}
                                        <option selected="selected" value = "gts">ГТС</option>
                                        <option value = "sts">CTC</option>
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group  col-md-6 my-class-padding">
                            <div class ="input-group col-md-12">
                                <label for="schema">Схема подключения</label>
                                <textarea class="form-control" placeholder="Схема подключения" name="schema" id="schema" rows=2 >{{point.schema_connect}}</textarea>
                            </div>
                        </div>

                        <div class="form-group  col-md-6 my-class-padding">
                            <div class ="input-group col-md-12">
                                <label for="notice">Примечание</label>
                                <textarea class="form-control" placeholder="Примечание" name="notice" id="notice" rows=2 >{{point.notice}}</textarea>
                            </div>
                        </div>
                        <input type="button" name="add" value ="изменить" class="btn btn-block btn-success " id="button-edit-point">
                        <div class="form-group response_order">
                            <p style="text-align: center; display: none;"></p>
                        </div>
                        {%endfor%}
                    </form>
            </div>
        </div>
    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>

    <script>
        var longitude = {{longitude}};
        var latitude = {{latitude}};
        var ip = '{{ip}}';
        var idPoint = {{idPoint}};
        var ssid = '{{ssidName}}';
        var businness = '{{businnessName}}';
        var placemark_color = '{{placemark_color}}';
    </script>
</header>


