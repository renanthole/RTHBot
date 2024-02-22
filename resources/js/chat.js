jQuery(function () {
    const baseUrl = "/api/chat";

    setMessage = async (id, message) => {
        try {
            $(".overlay").removeClass("d-none");

            const response = await fetch(`${baseUrl}/new`, {
                method: "POST",
                body: {
                    device: id,
                    message: message,
                },
            });
            const data = await response.json();

            await new Promise((resolve) => setTimeout(resolve, 1000));

            $(".overlay").addClass("d-none");

            return data.data;
        } catch (error) {
            $(".overlay").addClass("d-none");

            throw error;
        }
    };

    $("#setMessage").on("click", function (e) {
        e.preventDefault();

        let id = $(this).data("id");

        setMessage(id, $("#message").val());
    });
});
