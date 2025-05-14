// debounce function untuk live search
function debounce(fn, delay)
{
    let timeout;

    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(args), delay )
    }
}

// function nutuk api

function testing()
{
    console.log('bisa');
}

async function get_data(url, callback, id = -1)
{
    if(id !== -1) url = `${url}/${id}`;

    const response = fetch(`${url}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json' 
        }
    }).then(result => result.json())
    .then(result => {
        console.log(result);
        callback(result);

        return result;
    });

    return response;
}

async function api_store(url, form, file = false)
{
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let headers_data = {
        'Accept' : 'application/json',
        'X-CSRF-TOKEN' : csrfToken
    };



    // if(file) headers_data['Content-Type'] = 'multipart/form-data';

    const response = fetch(`${url}`, {
        method: 'POST',
        headers: headers_data,
        body: form
    }).then(result => result.json())
    .then(result => {
        console.log(result);
        return result;
    });

    return response;
}

async function api_update(url, form, id)
{
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const new_url = `${url}/${id}`;

    const response = fetch(new_url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            // 'Content-Type': 'application/json'
            'X-CSRF-TOKEN': csrfToken,
        },
        body: form
    }).then(response => response.json())
    .then(result => {
        console.log(result);
        return result;
    });

    return response;
}

async function api_destroy(url, id)
{
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const new_url = `${url}/${id}`

    const form = new FormData();
    form.append('_method', 'DELETE');

    const response = fetch(new_url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            
            // 'Content-Type': 'appication/json'
        },
        body: form
    }).then(result => result.json())
    .then(result => {
        console.log(result);
        return result;
    });
    
    return response;
}



