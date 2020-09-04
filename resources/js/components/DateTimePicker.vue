<template>
    <div class="w-full relative">
        <input type="hidden" :name="name" v-model="localValue" v-if="name" />
        
        <input
            type="text"
            readonly
            v-model="valueString"
            @click.stop="showDatepicker = !showDatepicker"
            @keydown.escape="showDatepicker = false"
            class="w-full pl-4 pr-10 py-3 leading-none form-input cursor-pointer"
            placeholder="Selecione uma data"
        />

        <div class="absolute top-0 right-0 px-3 py-2">
            <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>

        <div 
            v-cloak
            class="bg-white mt-12 rounded-lg shadow p-2 absolute top-0 left-0 z-50" 
            style="width: 17rem" 
            v-show="showDatepicker"
            v-on-clickaway="setShowDatepicker"
        >
            <div class="flex justify-around items-center mb-1">
                <button 
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                    @click="showing.year--">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron double left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-double-left b-icon bi"><g transform="translate(0 -0.5)"><g><path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path><path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>
                </button>
                <button 
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                    @click="showing.month == 0 ? (showing.year--, showing.month = 11) : showing.month--">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-left b-icon bi"><g transform="translate(0 -0.5)"><g><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>
                </button>
                <button @click="goToday">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="circle fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="text-blue-500"><g transform="translate(0 -0.5)"><g><circle cx="8" cy="8" r="8"></circle></g></g></svg>
                </button>
                <button
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                    @click="showing.month == 11 ? (showing.month = 0, showing.year++) : showing.month++">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-left b-icon bi"><g transform="translate(0 -0.5)"><g transform="translate(8 8) scale(-1 1) translate(-8 -8)"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>									  
                </button>
                <button
                    type="button"
                    class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                    @click="showing.year++">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron double left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-double-left b-icon bi"><g transform="translate(0 -0.5)"><g transform="translate(8 8) scale(-1 1) translate(-8 -8)"><path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path><path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>								  
                </button>
            </div>
            
            <div class="border border-gray-500 p-2 rounded">
                <div class="flex justify-center mb-1">
                    <div>
                        <span class="text-lg font-bold text-gray-800">{{ monthNames[showing.month] }}</span>
                        <span class="ml-1 text-lg text-gray-600 font-normal">{{ showing.year }}</span>
                    </div>
                </div>
                <div class="flex flex-wrap mb-3 -mx-1">
                    <div style="width: 14.26%" class="px-1" v-for="(day, index) in dayNames" :key="index">
                        <div class="text-gray-800 font-medium text-center text-xs">{{ day }}</div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-1">
                    <div 
                        v-for="blankday in blankdays"
                        :key="`${blankday}-blankday`"
                        style="width: 14.28%"
                        class="text-center border p-1 border-transparent text-sm"	
                    ></div>
                    <div style="width: 14.28%" class="px-1 mb-1" v-for="(dateOfMonth, dateIndex) in no_of_days" :key="'no_of_days_' + dateIndex">
                        <div
                            @click="selectDay(dateOfMonth)"
                            class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                            :class="[
                                {'font-bold': true},
                                {'bg-blue-500 text-white': isSelectedDate(dateOfMonth), },
                                {'text-blue-500': isToday(dateOfMonth) == true, },
                                {'text-gray-700 hover:bg-blue-200': isToday(dateOfMonth) == false && !isSelectedDate(dateOfMonth)},
                            ]"	
                        >{{ dateOfMonth }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-2 w-full border border-gray-500 p-2 rounded">
                <div class="flex align-center justify-center">
                    <select name="hours" class="bg-transparent text-xl appearance-none outline-none" v-model.number="selected.hour" @input.stop @change.stop>
                        <option :value="hour" v-for="hour in 24" :key="'day_hours_' + hour">{{ hour | addZeroLeft(2) }}</option>
                    </select>
                    <span class="text-xl mr-1">:</span>
                    <select name="minutes" class="bg-transparent text-xl appearance-none outline-none mr-4" v-model.number="selected.minute" @input.stop @change.stop>
                        <option :value="minute" v-for="minute in select_minutes" :key="`${minute}-minutes`">{{ minute | addZeroLeft(2) }}</option>
                    </select>
                </div>
            </div>
            <div class="flex mt-2">
                <button class="bg-gray-500 w-full rounded p-1 text-white mr-3" @click="cancel">
                    Cancelar
                </button>
                <button class="bg-green-500 w-full rounded p-1 text-white" @click="save">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway'; // Clique fora do elemento

import formatDate from 'date-fns/format';
import { Fragment } from 'vue-fragment';

require('quill/dist/quill.snow.css')
require('quill/dist/quill.bubble.css')

export default {
    mixins: [ clickaway ],
    components: {
        Fragment
    },
    props: {
        name: String,
        format: {
            type: String,
        },
        value: {
            type: String,
        },
        monthNames: {
            type: Array,
            default: () => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            validator: (months) => {
                if(months.length != 12) {
                    console.warn('Attributo [month-names] deve conter exatamente 12 elements (months)');
                    return false;
                }
                return true;
            }
        },
        dayNames: {
            type: Array,
            default: () => ['dom.', 'seg.', 'ter.', 'qua.', 'qui.', 'sex.', 'sáb'],
            validator: (months) => {
                if(months.length != 7) {
                    console.warn('Attributo [day-names] deve conter exatamente 7 elements (days)');
                    return false;
                }
                return true;
            }
        },
        minutesOffset: {
            type: Number,
            default: 10
        }
    },
    filters: {
        addZeroLeft(value, stringSize) {
            return `0000000${value}`.slice(-stringSize)
        }
    },
    data() {
        return {
            dateFormat: this.format || 'dd/MM/yyyy HH:mm:ss',

            today: new Date(),
            showDatepicker: false,
            localValue: this.value,

            // To create interval minutes
            select_minutes: Array.from({ length: Math.trunc(60/this.minutesOffset) }).map((minute, index) => index * this.minutesOffset),
            
            selected: {
                year: null,
                month: null,
                day: null,
                hour: 0,
                minute: 0
            },

            showing: {
                year: null,
                month: null
            }
        }
    },
    mounted() {
        this.initDate()
    },
    computed: {
        valueString() {
            return this.localValue ? this.formatDate(new Date(this.localValue), this.dateFormat) : null
        },
        no_of_days() {
            let daysInMonth = new Date(this.showing.year, this.showing.month + 1, 0).getDate();
            let daysArray = [];
            for ( var i=1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }
            return daysArray;
        },
        blankdays() {
            // find where to start calendar day of week
            let dayOfWeek = new Date(this.showing.year, this.showing.month).getDay();
            let blankdaysArray = [];
            for ( var i=1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }

            return blankdaysArray;
        }
    },
    methods: {
        formatDate,
        cancel() {
            this.showDatepicker = false
        },

        save() {
            this.changeValueAndEmitInputEvent()
            this.showDatepicker = false
        },

        setShowDatepicker() {
            this.showDatepicker = false
        },

        selectDay(day) {
            this.selected.day = day
            this.selected.month = this.showing.month
            this.selected.year = this.showing.year
        },

        initDate() {
            let date = this.value ? new Date(this.value) : new Date()

            let selected = {
                year: date.getFullYear(),
                month: date.getMonth(), // Loucura do JS começar o nr do mês com zero,
                day: date.getDate(),
                hour: date.getHours(),
                minute: this.value ? date.getMinutes() : 0
            }

            this.showing.year = date.getFullYear()
            this.showing.month = date.getMonth()

            this.selected = Object.assign(this.selected, selected)

            if(this.value) {
                this.changeValueAndEmitInputEvent()
            }
        },
        
        goToday() {
            this.showing.month = this.today.getMonth();
            this.showing.year = this.today.getFullYear();
        },

        isSelectedDate(day) {
            return new Date(this.selected.year, this.selected.month, this.selected.day).toDateString() === new Date(this.showing.year, this.showing.month, day).toDateString() ? true : false;
        },
        
        isToday(day) {
            return this.today.toDateString() === new Date(this.selected.year, this.selected.month, day).toDateString() ? true : false;
        },

        changeValueAndEmitInputEvent() {
            this.localValue = this.formatDate(
                new Date(this.selected.year, this.selected.month, this.selected.day, this.selected.hour, this.selected.minute), 
                'yyyy-MM-dd HH:mm:ss',
            )

            this.$emit('input', this.localValue)
        },
    }
}
</script>