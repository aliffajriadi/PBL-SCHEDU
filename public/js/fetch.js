// template untuk melakukan komunikasi kepada database dengan api

/* 
    debounce function untuk live search

    memberikan delay sebelum memanggil functionnya agar request api yang diberikan kepada database
    tidak over, hanya memanggil ketika user sudah tidak mengetik karakter baru setelah sekian detik.
*/
function debounce(fn, delay) {
    let timeout;

    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(args), delay);
    };
}

// function nutuk api

/*
    fungsi get_data digunakan untuk mengambil data dari database, dan data tersebut akan langsung dikelola
    menggunakan fungsi callback yang diberikan para parameter callback. 

    fungsi ini bisa digunakan untuk mencari sebuah data dengan id
    - jika ingin mencari data tertentu / mengakses function show pada api 
      tambahkan parameter id
    -jika ingin mencari lebih dari 1 data, tidak perlu mengisi parameter id

    */
async function get_data(url, callback, id = -1) {
    if (id !== -1) url = `${url}/${id}`;

    const response = fetch(`${url}`, {
        method: "GET",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
    })
        .then((result) => result.json())
        .then((result) => {
            console.log(result);
            callback(result);

            return result;
        });

    return response;
}

/* 
    fungsi api_store digunakan untuk membuat dan menyimpan data baru ke dalam database 
    dengan menerima input data dari form yang ditaruh ke dalam class FormData dengan js.
*/
async function api_store(url, form) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    let headers_data = {
        Accept: "application/json",
        "X-CSRF-TOKEN": csrfToken,
    };

    const response = fetch(`${url}`, {
        method: "POST",
        headers: headers_data,
        body: form,
    })
        .then((result) => result.json())
        .then((result) => {
            console.log(result);
            return result;
        });

    return response;
}

/* 
    fungsi api_update digunakan untuk mengubah data di dalam database dengan menerima input
    data dari form yang ditaruh ke dalam class FormData dengan js.
*/
async function api_update(url, form, id) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const new_url = `${url}/${id}`;

    form.append("_method", "PATCH");

    const response = fetch(new_url, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: form,
    })
        .then((response) => response.json())
        .then((result) => {
            console.log(result);
            return result;
        });

    return response;
}

/* 
    fungsi api_delete digunakan untuk menghapus data berdasatkan dari id yang diberikan pada
    parameter id.
*/
async function api_destroy(url, id) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const new_url = `${url}/${id}`;

    const form = new FormData();
    form.append("_method", "DELETE");

    const response = fetch(new_url, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": csrfToken,

            // 'Content-Type': 'appication/json'
        },
        body: form,
    })
        .then((result) => result.json())
        .then((result) => {
            console.log(result);
            return result;
        });

    return response;
}

function strLimit(text, limit = 100, end = '...') {
    if (text.length <= limit) return text;
    const sliced = text.slice(0, limit);
    const lastSpace = sliced.lastIndexOf(' ');
    return sliced.slice(0, lastSpace) + end;
  }
  

function formatTanggal(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        timeZone: "Asia/Jakarta",
        hour12: false,
    });
}
function formatTanggal1(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
        timeZone: "Asia/Jakarta",
        hour12: false,
    });
}
