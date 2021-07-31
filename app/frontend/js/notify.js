//функция вывода уведомлений
"use strict";
function notify(text, type, layout = "topRight") {
              new Noty({
                text        : text,
                type        : type,
                layout      : layout,
                theme       : 'sunset',
                dismissQueue: true,
                progressBar: true,
                timeout: 3000
              }).show();
            }
                                                        
        

