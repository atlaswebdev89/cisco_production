<header id="header-slogan-modal-2" class="pt-250 pb-250 light text-left">
                                <div class="container">
                                    <div class="row flex-md-vmiddle">
                                        <div class="col-md-12" id="button">
                                                <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                                                <p class="compressed-box-50 mb-100 dark text-center" style="">Статистика установленных точек доступа CiscoWifi</p>

                                            <div class="compressed-box-75 text-left dark">
                                               {% if (listDisk) %}
                                                    <ul class="diskYandex">
                                                        {% for data in listDisk %}
                                                         <li>
                                                             <span class = "arrow-collapse  menu-expand"  data-path ="{{data.path}}" data-type = "{{data.type}}">
                                                                 {% if data.type == 'dir'%}
                                                                    <i class="icon-folder2"></i>
                                                                 {% elseif data.type == 'file' %}
                                                                    <i class="icon-files"></i>
                                                                 {% endif %}
                                                                    {{data.name}}
                                                             </span>
                                                             
                                                             <span class="text-right"> ({{data.date}})</span>

                                                             {% if data.type == 'dir'%}
                                                             <ul class="collapse pl-25"></ul>
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
            
            



		