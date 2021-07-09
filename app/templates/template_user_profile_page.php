<header id="header-slogan-modal-2" class="pt-250 pb-250 light text-left">
    <div class="container">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button">
                <h2 class="dark text-center" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                <p class="compressed-box-50 mb-100 dark text-center" >
                    {{header}}<br>
                </p>
                    
                <div class="dark text-center">
                    <h4>
                        <h3><span style="color: #3dff53;">{{session.name}}  {{session.secondname}} </span> </h3>
                            <span>Статус: {{session.role}}</span><br/>
                            <span>Время входа: {{session.timeLogin}} </span> <br/>
                            <span>IP адрес: {{session.ip}} </span> <br/>
                            <span>Номер телефона {{session.phone}}</span><br/>
                            <span>Отдел {{session.JobsDepartment}}</span><br/><br/>
                                <div class="compressed-box-33">
                                    <input class="btn-info btn text-center" type="button" onclick="history.back();" value="Назад"/>
                                    <a href ="{{profileUser}}"  class="btn btn-block btn-success">ProfileUser</a>
                                    <a href ="{{profileUserPass}}"  class="btn btn-block btn-success">Изменить пароль</a>                                
                                </div>
                    </h4>
                </div> 
             </div>
        </div>
    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
</header>

 
