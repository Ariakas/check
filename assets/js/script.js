window.onload = () => {
    let table = $("#table");
    $("#reset").addEventListener("click", () => {
        table.querySelectorAll(".td").forEach(v => v.remove());
        loader(1);
        request("api/", { op: "delete_users" }, "POST").then(() => {
            loader(0);
        });
    });

    $("#add_user").addEventListener("click", (e) => {
        let name = $("#name").value,
            email = $("#email").value;
        if (name && email && $("#form").checkValidity()) {
            e.preventDefault();
            loader(1);
            request("api/", { op: "add_user", name, email }, "POST").then(response => {
                if (response.status === "success") {
                    get_users();
                    $("#name").value = "";
                    $("#email").value = "";
                }
                else {
                    loader(0);
                }
            });
        }
    });

    get_users();

    table.addEventListener("click", e => {
        let el = e.target;
        if (el.classList.contains("td")) {
            let user_id = el.getAttribute("data-id");
            if (user_id) {
                loader(1);
                request("api/", { op: "set_user_with_most_payment", user_id }, "POST").then(response => {
                    if (response.status === "success") {
                        get_users();
                    }
                    else {
                        loader(0);
                    }
                });
            }
        }
    });

    $("#popup_text_close").addEventListener("click", () => {
        $("#popup_text").classList.remove("visible");
    });

    $("#show_more_fractional").addEventListener("click", () => {
        message("In case of fractional amounts some indivisible part will be added randomly to one of the users. But you can just tap on another user to change that random. :)")
    });
}