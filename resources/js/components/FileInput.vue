<template>
    <div>
        <ul class="list-group mt-1">
            <li class="flex p-2 mb-1 items-center border border-gray-300 rounded" v-for="(file, index) in localFiles" :key="index">
                <div class="flex-initial">
                    <img :src="file.url" alt="" class="w-10 h-10 bg-red-800 object-cover">
                </div>
                <div class="flex flex-auto ml-2 items-center">
                    <div class="flex-auto">
                        <div class="flex flex-col">
                            <a :href="file.url" target="_blank" class="truncate max-w-xs">
                                {{ file.name }}
                            </a>
                        </div>
                        <span class="truncate max-w-xs">{{ formatBytes(file.size) }}</span>
                    </div>
                    <div class="ml-2">
                        <button class="bg-red-600 rounded-full p-2" @click="removeFile(index)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current text-white w-3 h-3"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
        <div class="rounded shadow mt-1 w-full bg-grey-light" v-show="progressBar > 0">
            <div class="rounded bg-blue-600 text-xs leading-none py-1 text-center text-white" :style="`width: ${progressBar}%`">{{ progressBar }}%</div>
        </div>
        <div 
            class="p-3 mt-1 form-input hover:bg-teal-700 hover:text-teal-100 text-teal-700 cursor-pointer" 
            @drop="onDrop"
            ref="dropContainer"
        >
            <label class="w-full flex flex-col items-center px-2 py-4 tracking-wide border border-dashed border-gray-300 cursor-pointer">
                <svg class="w-8 h-8 fill-current" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-2 text-base">{{ placeholder || 'Arraste arquivos ou Clique para escolher' }}</span>
                <input type='file' :id="name" :accept="accept" class="hidden" ref="input" :multiple="multiple" @change.stop="onChangeFileInput" @input.stop />
            </label>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        multiple: Boolean,
        placeholder: String,
        accept: {
            type: String,
            default: '*'
        },
        csrfToken: String,
        endpoint: {
            type: String,
            required: true
        },
        name: String,
        classNamespace: {
            type: String,
            required: true
        },
        filesDirectory: String,
        files: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            localFiles: this.files,
            progressBar: 0
        }
    },
    watch: {
        localFiles(newValue) {
            this.$emit('input', newValue)
        },
    },
    mounted() {
        this.bindDrop()
    },
    methods: {
        onChangeFileInput($event) {
            this.uploadFiles($event.target.files)
        },
        onDrop($event) {
            this.uploadFiles($event.dataTransfer.files)
        },
        uploadFiles(files) {
            let form_data = new FormData();
            form_data.append('component', this.classNamespace);
            // form_data.append('field_name', @json($field->name));
            form_data.append('dir', this.filesDirectory);
            // form_data.append('disk', '{{ $field->disk }}');

            for (let i = 0; i < files.length; i++) {
                form_data.append('files[]', files[i]);
            }

            const axiosConfig = { 
                headers: { 
                    'X-CSRF-Token': this.csrfToken 
                },
                onUploadProgress: (progressEvent) => {
                    this.progressBar = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                }
            }

            axios.post(this.endpoint, form_data, axiosConfig)
                .then(({ data }) => {
                    if(this.multiple) {
                        this.localFiles.push(...data.uploaded_files)
                    } else {
                        this.localFiles = [data.uploaded_files.shift()]
                    }
                })
                .finally(() => this.progressBar = 0);
        },
        removeFile(index) {
            this.localFiles.splice(index, 1)
        },
        bindDrop() {
            const dropContainer = this.$refs.dropContainer
        
            ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => dropContainer.addEventListener(eventName, (e) => (e.preventDefault(), e.stopPropagation()), false))

            ;['dragenter', 'dragover'].forEach(eventName => {
                dropContainer.addEventListener(eventName, highlight, false)
            })

            ;['dragleave', 'drop'].forEach(eventName => {
                dropContainer.addEventListener(eventName, unhighlight, false)
            })

            function highlight(e) {
                dropContainer.classList.add('bg-blue-800')
            }

            function unhighlight(e) {
                dropContainer.classList.remove('bg-blue-800')
            }
        },
        formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    }
}
</script>

<style>

</style>