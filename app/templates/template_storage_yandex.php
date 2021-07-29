<header id="header-slogan-modal-2" class="pt-250 pb-250 light text-left">
                                <div class="container">
                                    <div class="row flex-md-vmiddle">
                                        <div class="col-md-12" id="button">
                                                <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                                                <p class="compressed-box-50 mb-100 dark text-center" style="">Статистика установленных точек доступа CiscoWifi</p>

                                            <div class="container text-left dark">
                                               {% if (listDisk) %}
                                                    <ul class="diskYandex">
                                                        {% for data in listDisk %}
                                                         <li>
                                                            <div class="row no-pad static">
                                                                <div class="col-md-6 text-left">
                                                                    <span id = {{data.resourse_id}} class = "arrow-collapse  menu-expand"  data-path ="{{data.path}}" data-type = "{{data.type}}">
                                                                        {% if data.type == 'dir'%}
                                                                           <i class="icon-folder2"></i>
                                                                        {% elseif data.type == 'file' %}
                                                                           <i class="icon-files"></i>
                                                                        {% endif %}
                                                                           {{data.name}}
                                                                    </span>
                                                                </div>
                                                                {% if data.type == 'dir' %}
                                                                    <div class="col-md-3 ">
                                                                        <span class="control-panel dir">
                                                                            <i class="icon-download2 controlls" data-target = "download" data-title="Скачать"></i>
                                                                            <i class="icon-upload2 controlls"   data-target = "upload"  data-title="Загрузить"></i>
                                                                            <i class="icon-delete controlls"    data-target = "delete"  data-title="Удалить"></i>
                                                                            <i class="icon-box-add controlls"   data-target = "add"     data-title="Создать папку"></i>
                                                                            <i class="icon-loading controlls"   data-target = "update" data-title="Обновить"></i>
                                                                            <i class="icon-tag controlls"       data-target = "rename"  data-title="Переименовать"></i>
                                                                        </span>
                                                                    </div>
                                                                {% else %}
                                                                    <div class="col-md-3">
                                                                        <span class="control-panel file">
                                                                            <i class="icon-download2" data-title="Скачать"></i>
                                                                            <i class="icon-upload2" data-title="Загрузить"></i>
                                                                            <i class="icon-delete" data-title="Удалить"></i>
                                                                            <i class="icon-tag" data-title="Переименовать"></i>
                                                                        </span>
                                                                    </div>
                                                                {% endif %}
                                                                
                                                                <div class="col-md-3 text-right">
                                                                    <span>
                                                                       {{data.time}} | {{data.date}} 
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                            {% if data.type == 'dir'%}
                                                                <div class="row dynamic">
                                                                    <div class="col-md-12">
                                                                        <ul class="collapse pl-25"></ul>
                                                                    </div>
                                                                </div>   
                                                            {% endif %}
                                                        </li>
                                                        {% endfor %}
                                                    </ul>
                                               {% endif %}
                                            </div>
                                                        
                                        </div>
                                    </div>
                                </div>
                            <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
			</header>
            
            



		