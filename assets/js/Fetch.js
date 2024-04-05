async function request(url, data = {}, method = "GET") {
    let response;
    if (method === "POST") {
        let form = new FormData();
        for (let key of Object.keys(data)) {
            if (data[key] instanceof FileList) {
                for (let elem of data[key]) {
                    form.append(`${key}[]`, elem);
                }
            }
            else {
                form.append(key, data[key]);
            }
        }
        response = await fetch(url, {
            method: method,
            body: form
        });
    }
    else {
        if (Object.keys(data).length) {
            let params = new URLSearchParams(data);
            response = await fetch(`${url}?${params.toString()}`, {
                method: method
            });
        }
        else {
            response = await fetch(`${url}`, {
                method: method
            });
        }
    }
    response = await response.json();
    if (response.status === "error") {
        message(response.detail)
    }
    return response;
}