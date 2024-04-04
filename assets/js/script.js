$$ = s => document.querySelectorAll(s)

$ = s => document.querySelector(s)

loader = s => $("#loader").classList.toggle("visible", s);

get_users = () => {
    loader(1);
    request("api/", { op: "get_users" }, "POST").then(response => {
        if (response.status === "success") {
            let table = $("#table");
            table.querySelectorAll(".td").forEach(v => v.remove());
            for (let row of response.detail) {
                table.insertAdjacentHTML("beforeend", `
                    <div class="td" data-id="${row.id}">${row.name}</div>
                    <div class="td" data-id="${row.id}">${row.email}</div>
                    <div class="td" data-id="${row.id}">${parseFloat(row.payout)}€</div>
                `);
            }
        }
        loader(0);
    });
}

window.onload = () => {
    let table = $("#table");
    $("#reset").addEventListener("click", () => {
        table.querySelectorAll(".td").forEach(v => v.remove());
        loader(1);
        request("api/", { op: "delete_users" }, "POST").then(() => {
            loader(0);
        });
    });

    $("#add_user").addEventListener("click", () => {
        let name = $("#name").value,
            email = $("#email").value;
        if (name && email) {
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
}