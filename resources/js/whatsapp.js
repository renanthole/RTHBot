jQuery(function () {
    const baseUrl = "/api/whatsapp";

    getStatusDevice = async (id) => {
        try {
            // Show loading overlay
            $(".overlay").removeClass("d-none");

            const response = await fetch(`${baseUrl}/status/${id}`);
            const data = await response.json();

            // Simulate a delay (1 second) before hiding the overlay
            await new Promise((resolve) => setTimeout(resolve, 1000));

            // Hide loading overlay
            $(".overlay").addClass("d-none");

            return data.data;
        } catch (error) {
            // Hide loading overlay on error
            $(".overlay").addClass("d-none");

            throw error;
        }
    };

    $("#getStatus").on("click", function (e) {
        e.preventDefault();

        let id = $(this).data("id");

        getStatusDevice(id);
    })
});
