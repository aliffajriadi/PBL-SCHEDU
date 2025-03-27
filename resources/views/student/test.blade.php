<x-layout>
    <x-slot name="title">Test</x-slot>

    <h1 id="test">Test</h1>

    <p>This is a test page.</p>

    <script>
        async function fetchData() {
            const response = await fetch('profile');
            const data = await response.json();

            console.log(data);
        }
        
    </script>
</x-layout>