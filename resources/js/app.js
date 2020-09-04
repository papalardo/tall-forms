// Compatibilidade com livewire
import 'livewire-vue'

import Vue from 'vue'

require('./bootstrap');

require('./alpine/fields/multiselect')

Vue.config.productionTip = false;

Vue.component('rich-text', () => import('./components/RichTextEditor/RichTextEditor' /* webpackChunkName: "rich-text-component" */))
Vue.component('date-time-picker', () => import('./components/DateTimePicker' /* webpackChunkName: "date-time-picker" */))
Vue.component('multi-select', () => import('./components/MultiSelect' /* webpackChunkName: "multi-select" */))
Vue.component('file-input', () => import('./components/FileInput' /* webpackChunkName: "file-input" */))

window.Vue = Vue;

require('./components/livewireUseAsyncComponents')

new Vue({
    el: '#app'
})
