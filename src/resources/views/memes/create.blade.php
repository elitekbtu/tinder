<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавить новый мем') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('memes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Title Field -->
                        <div>
                            <x-input-label for="title" :value="__('Название')" />
                            <x-text-input
                                id="title"
                                name="title"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                placeholder="Введите название мема"
                            />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description Field -->
                        <div>
                            <x-input-label for="description" :value="__('Описание')" />
                            <textarea
                                id="description"
                                name="description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                rows="4"
                                placeholder="Добавьте описание мема (необязательно)"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Category Field with Select -->
                        <div>
                            <x-input-label for="category" :value="__('Категория')" />
                            <select
                                id="category"
                                name="category"
                                required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            >
                                <option value="" disabled selected>Выберите категорию</option>
                                <option value="funny">Смешные</option>
                                <option value="animals">Животные</option>
                                <option value="gaming">Игры</option>
                                <option value="movies">Кино</option>
                                <option value="other">Другое</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Image Upload Field -->
                        <div>
                            <x-input-label for="image" :value="__('Изображение')" />
                            <div class="mt-1 flex items-center">
                                <label for="image" class="cursor-pointer">
                                    <div class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Выбрать файл') }}
                                    </div>
                                    <input
                                        id="image"
                                        name="image"
                                        type="file"
                                        class="sr-only"
                                        required
                                        accept="image/jpeg,image/png,image/gif"
                                        onchange="previewImage(this)"
                                    />
                                </label>
                                <span id="file-name" class="ml-2 text-sm text-gray-500">Файл не выбран</span>
                            </div>
                            <div id="image-preview" class="mt-2 hidden">
                                <img id="preview" class="max-h-48 rounded-md" />
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4">
                            <x-secondary-button onclick="window.location='{{ route('memes.index') }}'">
                                {{ __('Отмена') }}
                            </x-secondary-button>
                            <x-primary-button type="submit">
                                {{ __('Сохранить мем') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const fileName = document.getElementById('file-name');
            const imagePreview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
                fileName.textContent = input.files[0].name;
            }
        }
    </script>
</x-app-layout>
