<header id="header-slogan-modal-2" class="pt-250 pb-250 light text-left">
    <div class="container">
        <div class="row flex-md-vmiddle">
            <div class="col-md-12" id="button">
                <h2 class="dark text-center" data-aos="zoom-in" data-aos-easing="none" data-aos-duration="500" data-aos-delay="0"><strong>Access Point</strong>&nbsp; CiscoWifi</h2>
                <p class="compressed-box-50 mb-100 dark text-center" >
                    {{header}}<br>
                </p>
                <div class="dark text-center compressed-box-50">  
                    <input class="btn-info btn text-center" type="button" onclick="history.back();" value="Назад"/>
                       <form class=" m-auto point-redactor" method="POST">
                                <div class="form-group ">
                                    <div class ="input-group">
                                        <input type="text" class="form-control"  placeholder="Ваше имя" name="secondname" id="secondname"  value = "{{session.secondname}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class ="input-group">
                                        <input type="text" class="form-control"  placeholder="Фамилия" name="name" id="name"  value = "{{session.name}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class ="input-group">
                                        <input name = "phone" id = "phone" type="text" class="form-control bfh-phone" data-format="+375 (dd) ddd-dd-dd" value = "{{session.phone}}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class ="input-group ">
                                        <input type="text" placeholder="Структурное подразделение" class="form-control" id="JobsDepartment" name = "JobsDepartment"  value = "{{session.JobsDepartment}}"required>
                                    </div>
                                </div>
                                    <input type="button" name="editdataUser" value ="изменить" class="btn btn-block btn-success " id="editdataUser">
                                    <div class="form-group response_order">
                                            <p style="text-align: center; display: none;"></p>
                                    </div>
                        </form>
                </div> 
             </div>
        </div>
    </div>
    <div class="bg parallax-bg skrollable-after" data-top-bottom="transform:translate3d(0px, 25%, 0px)" data-bottom-top="transform:translate3d(0px, -25%, 0px)"></div>
    
    <script>
        var UserId = {{session.user_id}};
    </script>
</header>

 
