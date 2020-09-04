<template>
  <div class="flex flex-col items-center relative" v-on-clickaway="closeDropdown" >
        <div class="w-full" ref="containerInput" @click="$refs.input.focus(), dropdownOpened = true">
            <div :class="['p-1 flex form-input', { 'shadow-outline' : dropdownOpened }]">
                <div class="flex flex-auto flex-wrap">
                    <div
                        class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-teal-700 bg-teal-100 border border-teal-300" 
                        v-for="(value, label) in localValue" :key="`pill-${label}`"
                    >
                        <div class="text-xs font-normal leading-none max-w-full flex-initial">{{ label }}</div>
                        <div class="flex flex-auto flex-row-reverse" @click="dropdownOpened = false">
                            <div @click="$delete(localValue, label)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-teal-400 rounded-full w-4 h-4 ml-2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <input
                            ref="input"
                            autocomplete="none" 
                            class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800" 
                            v-model="search"
                            :placeholder="placeholder"
                            @input.stop
                            @change.stop
                            @focus="dropdownOpened = true"
                            @keydown.enter="(addOnEnter && Object.values(localValue).length < limit) ? addInValueOnEnter() : 'javascript:void(0);'"
                        >
                    </div>
                </div>
                <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200" x-on:click="open = !open">
                    <button x-bind:class="{'cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none transform transition duration-200 origin-center': true, 'rotate-180': open }">
                        <svg xmlns="http://www.w3.org/2000/svg" style="margin: 2px" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up w-4 h-4">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div 
            class="absolute top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto shadow-md border border-gray-200" 
            v-show="dropdownOpened" 
            :style="[{ top: topPositionOptions + 'px' }]"
        >
            <div class="flex flex-col w-full" style="max-height: 20rem">
                <div class="cursor-wait w-full border-gray-100 rounded-t border-b" v-show="searchBusy">
                    <div class="flex w-full items-center justify-center p-2 pl-2 border-transparent">
                        <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-3 w-3"></div>
                    </div>
                </div>
                    <div
                        :class="[
                            'cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100', 
                            { 'bg-gray-200 cursor-not-allowed text-gray-400': checkIfOptionDisabled(label) }
                        ]" 
                        @click="checkIfOptionDisabled(label) ? () => {} : toggle(value, label)"
                        v-for="(value, label) in showOptions" 
                        :key="label"
                    >
                        <div :class="[{
                                'flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative': true, 
                                'border-teal-600': localValue.hasOwnProperty(label),
                                'hover:border-teal-600': !checkIfOptionDisabled(label)
                            }]"
                        >
                            <div class="w-full items-center flex">
                                <div class="mx-2 leading-6">{{ label }}</div>
                            </div>
                        </div>
                    </div>
                <div class="w-full border-gray-100 rounded-t border-b" v-show="!searchBusy && !Object.values(showOptions).length">
                    <div class="flex w-full items-center justify-center p-2 pl-2 border-transparent">
                        Nenhum resultado encontrado
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway'; // Clique fora do elemento
import debonce from 'lodash-es/debounce'

export default {
    mixins: [ clickaway ],
    props: {
        options: {
            type: Object,
            default: () => {}
        },
        limit: {
            type: Number,
            default: Infinity  
        },
        addOnEnter: {
            type: Boolean,
            default: false
        },
        realtimeSearchEnabled: {
            type: Boolean,
            defualt: false
        },
        value: {
            type: Object,
        },
        placeholder: {
            type: String,
            default: '',
        },
        livewireCtx: {
            type: String,
        },
        livewireFieldKey: String
    },
    data() {
        return {
            localValue: this.value || Object.assign({}),
            fieldKey: this.livewireFieldKey,
            localOptions: this.options,
            search: '',
            dropdownOpened: false,
            searchBusy: false,
            selectedValues: this.value,
            topPositionOptions: 0,
        }
    },
    watch: {
        search() {
            this.initSearchOptions()
        },
        localValue(newValue) {
            this.$emit('input', newValue)

            this.$nextTick(() => this.setPositionOptions())
        }
    },
    mounted() {
        this.setPositionOptions()

        if(this.realtimeSearchEnabled && this.livewireFieldKey) {
            if(document.readyState !== 'complete') {
                window.livewire.on('multiselect-options-changed.' + this.livewireFieldKey, options => {
                    this.searchBusy = false
                    this.localOptions = options
                })
            }
        }
    },
    computed: {
        showOptions() {
            return this.realtimeSearchEnabled ? this.localOptions : this.filtredOptions
        },
        filtredOptions() {
            const values =  Object.entries(this.options).filter(([value, label]) => {
                return value.toLowerCase().includes(this.search.toLowerCase()) || label.toLowerCase().includes(this.search.toLowerCase())
            })
            return values.reduce((acc, [value, label]) => (acc[label] = value, acc), {})
        },
    },
    methods: {
        addInValueOnEnter() {
            this.$set(this.localValue, this.search, null)
            this.search = ''
        },
        checkIfOptionDisabled(label) {
            return !this.localValue.hasOwnProperty(label) && Object.values(this.localValue).length >= this.limit
        },
        closeDropdown() {
            this.dropdownOpened = false
        },
        setPositionOptions() {
            this.topPositionOptions = this.$refs.containerInput.offsetHeight + 5
        },
        toggle(value, label) {
            if(this.localValue.hasOwnProperty(label)) {
                this.$delete(this.localValue, label)
            } else {
                this.$set(this.localValue, label, value)
            }
        },
        getLivewireComponentId() {
            return this.livewireCtx.replace('window.livewire.find(\'', '').replace('\')', '')
        },
        initSearchOptions() {
            if(this.realtimeSearchEnabled) {
                this.searchBusy = true
                this.localOptions = Object.assign({})
                this.searchOptions()
            }
        },
        searchOptions: debonce(function() {
            if(this.realtimeSearchEnabled) {
                if(!this.livewireCtx || !this.livewireFieldKey) {
                    console.error(`[MultiSelect] - livewireCtx or livewireFieldKey undefined when realtime search enabled`)
                    return;
                }
                window.livewire.find(this.getLivewireComponentId()).call('multiSelectSearch', this.livewireFieldKey, this.search)
            }
        }, 1000),
    }
}
</script>

<style>

</style>