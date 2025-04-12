<div class="bg-white shadow-md items-center rounded-2xl w-full p-3 flex justify-between">
    <div class="flex gap-2 text-sm ">
        <a href="" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300 bg-emerald-400 text-white">Dashboard</a>
        <a href="" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300">Notes</a>
        <a href="" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300">Task</a>
        <a href="" class="hover:bg-emerald-400 hover:text-white rounded-md px-3 py-1.5 transition-all duration-300">Schedule</a>
    </div>
    @if ($type == "name")
    <p class="text-sm">Kelas Bahasa indonesia 8C</p>
    @elseif ($type == "search")
    <input type="text" id="search" placeholder="Search {{$page}}...."
            class="mt-2 sm:mt-0 w-full sm:w-1/3 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300 transition-all"
            onkeyup="getSearch()">
    @endif
</div>

<script>
    function getSearch() {
            
            let input = document.getElementById("search").value.toLowerCase();
            let items = document.querySelectorAll(".{{$page}}");

            items.forEach(item => {
                let text = item.textContent.toLowerCase();
                if (text.includes(input)) {
                    item.classList.remove("hidden");
                } else {
                    item.classList.add("hidden");
                }
            });
        }
</script>