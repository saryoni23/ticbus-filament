<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24 -mx-3">
                <div class="w-full">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Form Pencarian Tiket
                            </h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <form method="POST" action="" class="px-4 py-5 sm:p-6">
                                @csrf
                                <div class="mb-4">
                                    <label for="category"
                                        class="block text-sm font-medium text-gray-700">Category</label>
                                    <select x-init="$($el).select2({})" id="category" name="category"
                                        class="select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="" disabled selected>-- Pilih Tipe Bus --</option>
                                        @foreach ($tipebus as $bus)
                                        <option value="{{ $bus->id }}">{{ $bus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="start" class="block text-sm font-medium text-gray-700">Rute
                                        Awal</label>
                                    <select x-init="$($el).select2({})" id="start" name="start"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="" disabled selected>-- Pilih Rute Awal --</option>
                                        @foreach ($start as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="end" class="block text-sm font-medium text-gray-700">Rute
                                        Akhir</label>
                                    <select x-init="$($el).select2({})" id="end" name="end"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="" disabled selected>-- Pilih Rute Akhir --</option>
                                        @foreach ($end as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu
                                        Berangkat</label>
                                    <input type="date" id="waktu" name="waktu"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cari Tiket
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

</div>
