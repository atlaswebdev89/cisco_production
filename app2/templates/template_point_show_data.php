<header id="header-slogan-modal-2" class="pt-200 pb-250 light">
      <div class="container">
         <div class="row flex-md-vmiddle">
           <div class="col-md-12" id="button">
             <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
             <p class="compressed-box-50 mb-100 dark text-center" style="">
                   Данные точки Сisco<br>
               </p>
                     <div id="button-panel" class="dark" style="text-align: right; margin-bottom: 10px;">
                         <a id = "printLabel" class="btn-info btn navbar-left "  onclick="window.print()"   title="Печать"><i class="icon-printer2"></i></a>
                         <input class="btn-info btn text-center" type="button" onclick="history.back();" value="Назад"/>
                            {% if show_block_moderator %}
                               <a  class="btn btn-primary" href="{{edit}}">Изменить</a>
                                   {% if show_block_admin %}
                                          <button  class="btn btn-danger" id="point_del"  data-id-point = "{{id}}">Удалить</button>
                                   {% endif %}
                            {% endif %}
                     </div>
                

                 <table class="table table-bordered table-inverse  table-responsive dark text-center">
                        <tbody>
                          {%for data in dataPoint%}
                                        <tr>
                                            <th scope="row">Ip адрес</th>
                                            <td>{{ data.ip }}</td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Название сети (ssid)</th>
                                          <td>{{ data.ssid }}</td>
                                        </tr>
                                          <tr>
                                              <th scope="row">Оплата</th>
                                              {% if data.payment == 'free' %}
                                                    <td>Общедоступная точка wifi</td>
                                              {% elseif data.payment == 'pay' %}
                                                    <td>CiscoWifi в пользованиие</td>
                                              {% else %}
                                                    <td></td>
                                              {% endif %}
                                          </tr>
                                        <tr>
                                            <tr>
                                          <th scope="row">MAC адрес</th>
                                          <td>{{ data.mac }}</td>
                                        </tr>
                                         <tr>
                                          <th scope="row">Тип точки</th>
                                          <td>{{ data.type }}</td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Модель точки</th>
                                          <td>{{ data.model }}</td>
                                        </tr>  
                                          <th scope="row">Организация</th>
                                          <td>{{ data.name }}</td>
                                        </tr>  
                                        
                                        <tr>
                                          <th scope="row">Входящая скорость (мб/с)</th>
                                          <td>{{ data.speed_download }}</td>
                                        </tr>
                                        <tr>
                                          <th scope="row">Исходящая скорость (мб/с)</th>
                                          <td>{{ data.speed_upload }}</td>
                                        </tr>
                                       
                                        <tr>
                                          <th scope="row">Дата установки</th>
                                          <td>{{ data.installation_date }}</td>
                                        </tr>

                                        <tr>
                                          <th scope="row">Адрес установки</th>
                                          <td>{{ data.address }} </td>
                                        </tr>
                                        <tr>
                                              <th scope="row">Обслуживание</th>
                                              {% if data.responsibility == 'gts' %}
                                                    <td>ГТС</td>
                                              {% elseif data.responsibility == 'sts' %}
                                                    <td>СТС</td>
                                              {% else %}
                                                    <td></td>
                                              {% endif %}

                                        </tr>
                                        <tr>
                                          <th scope="row">Место установки</th>
                                          <td>{{ data.set_place }}</td>
                                        </tr>
                                          <tr>
                                              <th scope="row">Схема подключения</th>
                                              <td>{{ data.schema_connect }}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Контакты заказчика</th>
                                              <td>{{ data.customer }}</td>
                                          </tr>
                                        <tr>
                                          <th scope="row">Примечание</th>
                                          <td>{{ data.notice }}</td>
                                        </tr>

                            {%endfor%}  
                        </tbody>
                 </table>
               <div id ="allMapsButton" class="text-center dark">
                   <span><a href="{{maps}}">Показать на общей карте</a></span>
               </div>
                     <div id="map" ></div>
             </div>  
           
                
           </div>
        </div>
       <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>

    <script>
        var longitude = {{longitude}};
        var latitude = {{latitude}};
        var ip = '{{ip}}';
        var ssid = '{{ssid}}';
        var businness = '{{businness}}';
        var placemark_color = '{{placemark_color}}';
    </script>



</header>

