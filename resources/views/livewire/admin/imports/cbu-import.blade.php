<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    //

    <div>
        <div class="flex flex-col flex-grow mb-3">
            <div x-data="{ files: null }" id="FileUpload" class="relative block w-full px-3 py-2 bg-white border-2 border-gray-300 border-solid rounded-md appearance-none hover:shadow-outline-gray">
                <input type="file" multiple
                       class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0"
                       x-on:change="files = $event.target.files; console.log($event.target.files);"
                       x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                >
                <template x-if="files !== null">
                    <div class="flex flex-col space-y-1">
                        <template x-for="(_,index) in Array.from({ length: files.length })">
                            <div class="flex flex-row items-center space-x-2">
                                <template x-if="files[index].type.includes('audio/')"><i class="far fa-file-audio fa-fw"></i></template>
                                <template x-if="files[index].type.includes('application/')"><i class="far fa-file-alt fa-fw"></i></template>
                                <template x-if="files[index].type.includes('image/')"><i class="far fa-file-image fa-fw"></i></template>
                                <template x-if="files[index].type.includes('video/')"><i class="far fa-file-video fa-fw"></i></template>
                                <span class="font-medium text-gray-900" x-text="files[index].name">Uploading</span>
                                <span class="self-end text-xs text-gray-500" x-text="filesize(files[index].size)">...</span>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="files === null">
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                        <p class="text-gray-700">Drag your files here or click in this area.</p>
                        <a href="javascript:void(0)" class="flex items-center px-4 py-2 mx-auto font-medium text-center text-white bg-red-700 border border-transparent rounded-md outline-none">Select a file</a>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
