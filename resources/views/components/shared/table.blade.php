<section class="py-8 bg-blueGray-50" x-data="{ showContent: false }">
    <div class="container px-4 mx-auto">
        <div class="p-7 pb-12 pt-12 bg-white rounded-5xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="pl-10 xl:pl-24 text-3xl font-heading font-medium">
                    {{ $title ?? 'Table Title' }}
                </h2>
                @isset($actions)
                    <div class="mt-4 md:mt-0 md:pr-10 xl:pr-24">
                        {{ $actions }}
                    </div>
                @endisset
            </div>

            {{ $slot }}
        </div>
    </div>
</section>
