<x-layout title="Test" role="student">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <form id="myForm" class="flex flex-col gap-3">
     
        <input class="border-2 border-amber-200 rounded-2xl px-3 py-1" type="number" name="nama" >
        <input class="border-2 border-amber-200 rounded-2xl px-3 py-1" type="number" name="umur" >
        <button class="p-3 rounded-2xl bg-amber-400 text-white" type="submit">submit</button>
    </form>

    <div id="hasil">
        isi angka terlebih dahulu
    </div>
    
    <script>
        const form = document.getElementById('myForm')

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const formData = new FormData(form)
            fetch('http://127.0.0.1:8000/api/testing', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('hasil').innerHTML = data.balasan;
            })
        })
        
    </script>
    


</x-layout>
