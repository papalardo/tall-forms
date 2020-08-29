require('./bootstrap');

import format from 'date-fns/format';
// import dateIsEqual from 'date-fns/is_equal'

// window.dateIsEqual = dateIsEqual
window.formatDate = format

require('./alpine/fields/multiselect')

require('./vendor/quill.js');
window.Quill = require('Quill');

require('quill/dist/quill.snow.css')
require('quill/dist/quill.bubble.css')

/* Make Alpine wait until Livewire is finished rendering to do its thing. */
window.deferLoadingAlpine = function (callback) {
    window.addEventListener('livewire:load', function () {
        callback();
    });
};