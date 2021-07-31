'use strict';
function errorApiHandler (message) {
        notify('Ошибка - '+message.code+'<br>'+message.message, 'error');
}
