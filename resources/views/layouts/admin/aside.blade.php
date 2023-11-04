<aside class="bg-gray-800 px-3 text-white w-48 flex-shrink-0">
    <ul class="gap-4 grid">
        <li x-data="{ open: false }">
            <div x-on:click="open = ! open" class="flex justify-between items-center cursor-pointer">
                <h2>Store</h2>
                <i x-bind:class=" open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"></i>
            </div>

            <ul x-show="open" class="mt-1 flex flex-col gap-1">
                <a href="{{ route('admin.products.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        products
                    </li>
                </a>
                <a href="{{ route('admin.categories.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        categories
                    </li>
                </a>
                <a href="{{ route('admin.brands.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        brands
                    </li>
                </a>
                <a href="{{ route('admin.orders.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        orders
                    </li>
                </a>
            </ul>
        </li>
        <li x-data="{ open: false }">
            <div x-on:click="open = ! open" class="flex justify-between items-center cursor-pointer">
                <h2>Settings</h2>
                <i x-bind:class=" open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"></i>
            </div>

            <ul x-show="open" class="mt-1 flex flex-col gap-1">
                <a href="{{ route('admin.properties.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        properties
                    </li>
                </a>
                <a href="{{ route('admin.options.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        options
                    </li>
                </a>
                <a href="{{ route('admin.users.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        users
                    </li>
                </a>
                <a href="{{ route('admin.seos.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        seo
                    </li>
                </a>
            </ul>
        </li>
    </ul>
</aside>
