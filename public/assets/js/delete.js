$(function() {

    $("button[name='deleteButton']").click(function() {
        let userId = $(this).val();

        $.ajax({
            url: '/delete-ajax',
            type: "POST",
            data: {id: userId},

            success: function(data) {
                let element = $("#user" + userId);
                element.remove();
            },

            error: function(data) {
                if (data.status === 403) {
                    alert('Доступ запрещен. Вы не администратор');
                } else if (data.status === 406) {
                    alert('Вы не можете удалить собственный аккаунт');
                } else if (data.status === 400) {
                    alert('Неверный запрос');
                } else {
                    alert('Возникла ошибка');
                }
            }
        });
    })
});