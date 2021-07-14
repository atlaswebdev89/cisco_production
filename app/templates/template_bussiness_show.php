<header id="header-slogan-modal-2" class="pt-200 pb-250 light">
    <div class="container">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button">
                <h2 class="dark text-center" style="" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                <p class="compressed-box-50 mb-100 dark text-center" style="">
                    Точки организации<br>
                </p>
                <form class="compressed-box-50 m-auto point-redactor text-center dark"  method="">
                    <input class="btn-info btn text-center" type="button" onclick="history.back();" value="Назад"/><br />
                </form>


                    <table class="table table-bordered table-inverse table-responsive dark text-center">
                        <tbody>
                                <tr>
                                    <th scope="col">Адрес</th>
                                    <th scope="col">Точки</th>
                                </tr>
                                {% for data in address %}
                                    <tr>
                                        {% if data.address %}
                                            <td>{{data.address}}</td>
                                        {% else %}
                                            <td>Адрес не указан</td>
                                        {% endif %}

                                        {% if data.id_address%}
                                            <td><a href = "{{url}}{{data.id_address}}">{{data.point}}</a></td>
                                        {% else %}
                                            <td><a href = "{{url}}not">{{data.point}}</a></td>
                                        {% endif %}

                                    </tr>
                                {% endfor %}
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
</header>


