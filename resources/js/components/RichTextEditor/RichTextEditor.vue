<template>
    <div>
        <progress :value="uploadImageProgress" v-show="showProgressOnUploadImage && uploadImageProgress > 0"></progress>
        <div class="form-input p-0">
            <div class="w-full" ref="editor">
                <input ref="imageInput" class="hidden" type="file" accept="image/*" @change.stop="inputImageChange">
            </div>
        </div>
        <fragment v-if="name">
            <textarea type="hidden" :name="name" v-model="localValue" class="hidden"></textarea>
            <input type="hidden" :name="`${mediaIdName}[]`" v-for="mediaId in mediaIds" :key="mediaId" />
        </fragment>
    </div>
</template>

<script>
import imageHandlerMixin from './imageHandlerMixin'
import registerModulesMixin from './registerModulesMixin'

import Quill from 'quill';

import { Fragment } from 'vue-fragment'

require('quill/dist/quill.snow.css')
require('quill/dist/quill.bubble.css')

export default {
    mixins: [
        imageHandlerMixin, 
        registerModulesMixin
    ], 
    props: {
        name: String,
        mediaIdName: {
            type: String,
            default: 'mediaIds'
        },
        value: {
            type: String,
            default: ''
        },
        livewireCtx: {
            type: String,
            required: true
        },
        livewireSetMediaIds: {
            type: Boolean,
            default: false,
        },
        csrfToken: {
            type: String
        },
        uploadImageEndpoint: {
            type: String
        },
        showProgressOnUploadImage: {
            type: Boolean,
            default: false
        },
    },
    components: {
        Fragment
    },
    data() {
        return {
            localValue: '',
            quillModules: {},
            mediaIds: [],
            uploadImageProgress: 0,
        }
    },
    mounted() {
        if(document.readyState !== 'complete') {
            this.bindQuill()
        }
    },
    methods: {
        bindEmitEvents() {
            const emitInput = () => (this.localValue = this.editor.getText() ? this.editor.root.innerHTML : '', this.$emit('input', this.localValue))

            /**
             * Prevent bugs when children element emit input
             */
            this.editor.root.addEventListener('input', function(event) {
                event.stopPropagation()
            })

            /**
             * Livewire isnt detecting change event, 
             * then I do manually on blur emit input when 
             * .lazy modifier exists in wire:model attribute
             */ 
            if(Object.values(this.$el.attributes).some(attribute => attribute.name.includes('wire:model.lazy'))) {
                this.editor.root.addEventListener('blur', emitInput);
            } else {
                this.editor.on('text-change', emitInput);
            }
        },
        bindQuill() {
            this.registerModules(Quill);

            this.editor = new Quill(this.$refs.editor, {
                modules: this.quillModules,
                theme: 'snow',
            });

            this.editor.root.innerHTML = this.value;

            this.bindEmitEvents()
        },
        getLivewireComponentId() {
            return this.livewireCtx.replace('window.livewire.find(\'', '').replace('\')', '')
        },
        setLivewireMediaIds() {
            window.livewire.find(this.getLivewireComponentId()).set('rich_text_media_ids', this.mediaIds)
        },
        inputImageChange(event) {
            this.imageHandler(event.target.files[0])
        },
    }
}
</script>