jQuery(function () {
    const baseUrl = "/api/chat";

    function sendMessage(id, chat, phone, message) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: `${baseUrl}/new`,
                method: "POST",
                data: {
                    device: id,
                    chat: chat,
                    phone: phone,
                    message: message,
                },
                dataType: "JSON",
                beforeSend: function () {
                    $("#message").val('');
                    $(".overlay").removeClass("d-none");
                },
                success: function (data) {
                    setTimeout(() => {
                        $(".overlay").addClass("d-none");
                        resolve(data.data);
                    }, 1000);
                },
                error: function (xhr, status, error) {
                    $(".overlay").addClass("d-none");
                    reject(error);
                },
            });
        });
    }

    function getMessages(chat) {
        $.ajax({
            url: "/chats/" + chat,
            type: "GET",
            dataType: "html",
            beforeSend: function () {
                $(".overlay").removeClass("d-none");
            },
            success: function (data) {
                $(".overlay").addClass("d-none");
                $("#messages").html(data);
            },
        });
    }

    $("#setMessage").on("click", function (e) {
        e.preventDefault();

        let id = $(this).data("id");
        let chat = $("#chat").val();
        let phone = $("#phone").val();
        let message = $("#message").val();

        sendMessage(id, chat, phone, message);

        getMessages(chat);
    });    

    setInterval(function() {
        let chat = $("#chat").val();

        getMessages(chat);
    }, 5000);
});
