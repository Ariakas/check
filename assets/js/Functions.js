const $$ = s => document.querySelectorAll(s)

const $ = s => document.querySelector(s)

const loader = s => $("#loader").classList.toggle("visible", s);

const message = m => {
    $("#popup_text_message").innerText = m;
    $("#popup_text").classList.add("visible");
}

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

