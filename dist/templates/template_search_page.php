<header id="header-slogan-modal-2" class="pt-200 pb-250 light">
    <div class="container">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button">
                <h2 class="dark text-center" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                <p class="compressed-box-50 mb-100 dark text-center" >
                     Поиск точки доступа CiscoWifi<br>
                </p>

                <form action="/search/" method="get">
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3 col-xs-12 input-group">
                            <span class="input-group-addon"><i class="icon-spinner9"></i></span>
                            <input type="search" class="form-control" id="searchRequest" name="searchRequest" placeholder="Поиск..." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-4" >
                            <button type="submit" class="btn btn-default">Поиск</button>
                        </div>
                    </div>
                </form>

                {% if message %}
                <div class="col-md-12 pt-25" >
                    <h2 class ="dark text-center" ><span style="color: #ffefef; font-family: 'Amatic SC', cursive !important;">{{message}}</span></h2>
                </div>
                {% endif %}


                {% for data in point %}
                <div class="dark parent-block" style="color: #FFFFFF; font-size: 16px;">
                    <div class="col-md-12 col-xs-12 point-data" style="border: 1px solid silver; border-radius: 5px; margin: 5px; padding-bottom: 10px; padding-top: 10px;">
                        <div class="col-md-2">
                            <div ><i class="icon-podcast icon-position-left" ></i><a href="/point/show/id/{{data.id}}" style="color: #3dff53" >{{data.ip}}</a></div>
                        </div>
                        <div class="col-md-4">
                            <div><i class="icon-location22 icon-position-left" ></i>{{data.address}}</div>
                        </div>
                        <div class="col-md-2">
                            <div><i class="icon-library3 icon-position-left"></i><a href="#">{{data.name}}</a></div>
                        </div>
                        <div class="col-md-2">
                            <span>Активация: {{ data.installation_date }}</span>

                        </div>
                        <div class="col-md-2">
                            {% if show_block_moderator %}
                            <a href="/point/edit/id/{{data.id}}"><i class="icon-hammer3 icon-position-left"></i></a>
                            {% if show_block_admin %}
                            <a class="point_del"  data-id-point = "{{data.id}}"><i class="icon-cross3 icon-position-left"></i></a>
                            {% endif %}
                            {% endif %}
                        </div>
                    </div>
                </div>
                {% endfor %}

            </div>

        </div>

        {% if navigation %}
        <div class="row ">
            <div class="col-md-12">
                <nav class="text-center">
                    <ul class="pagination text-center  justify-content-center">
                        {% if navigation.first %}
                        <li><a href="{{uri}}{{navigation.first}}{{getRequest}}">start</a></li>
                        {% endif %}

                        {% if navigation.last_page %}
                        <li><a href="{{uri}}{{navigation.last_page}}{{getRequest}}"> < </a></li>
                        {% endif %}

                        {% if navigation.previous %}
                        {% for data in navigation.previous %}
                        <li><a href="{{uri}}{{data}}{{getRequest}}"> {{data}} </a></li>
                        {% endfor %}
                        {% endif %}

                        {% if navigation.current %}
                        <li class="active"><a href="{{uri}}{{navigation.current}}{{getRequest}}"> {{navigation.current}} </a></li>
                        {% endif %}

                        {% if navigation.next %}
                        {% for data in navigation.next %}
                        <li><a href="{{uri}}{{data}}{{getRequest}}"> {{data}} </a></li>
                        {% endfor %}
                        {% endif %}

                        {% if navigation.next_pages %}
                        <li><a href="{{uri}}{{navigation.next_pages}}{{getRequest}}"> > </a></li>
                        {% endif %}

                        {% if navigation.end %}
                        <li><a href="{{uri}}{{navigation.end}}{{getRequest}}">End</a></li>
                        {% endif %}
                    </ul>
                </nav>
            </div>
        </div>
        {% endif %}

    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
</header>