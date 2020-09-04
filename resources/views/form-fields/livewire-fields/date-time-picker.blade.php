<div 
    class="block"
    wire:model="{{ $field->key }}"
>
    <label class="text-gray-700" for="{{ $field->key }}">{{ $field->label }}</label>
    <div
        x-data='app({
            value: @json($form_data[$field->name] ?? null)
        })'
        x-init="[initDate(), getNoOfDays()]" 
        wire:ignore
        x-on:date-changed="dispatchInputEvent($el)"
    >
        <div
            class="w-full relative"
        >
            <input
                type="text"
                readonly
                x-model="valueString"
                x-on:click="showDatepicker = !showDatepicker"
                x-on:keydown.escape="showDatepicker = false"
                class="w-full pl-4 pr-10 py-3 leading-none form-input cursor-pointer"
                placeholder="Selecione uma data">

                <div class="absolute top-0 right-0 px-3 py-2">
                    <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div 
                    x-cloak
                    class="bg-white mt-12 rounded-lg shadow p-2 absolute top-0 left-0 z-50" 
                    style="width: 17rem" 
                    x-show.transition="showDatepicker"
                    @click.away="showDatepicker = false">

                    <div class="flex justify-around items-center mb-1">
                        <button 
                            type="button"
                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                            @click="year--; getNoOfDays()">
                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron double left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-double-left b-icon bi"><g transform="translate(0 -0.5)"><g><path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path><path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>
                        </button>
                        <button 
                            type="button"
                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                            :class="{'cursor-not-allowed opacity-25': month == 0 }"
                            :disabled="month == 0 ? true : false"
                            @click="month--; getNoOfDays()">
                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-left b-icon bi"><g transform="translate(0 -0.5)"><g><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>
                        </button>
                        <button x-on:click="goToday">
                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="circle fill" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="text-blue-500"><g transform="translate(0 -0.5)"><g><circle cx="8" cy="8" r="8"></circle></g></g></svg>
                        </button>
                        <button
                            type="button"
                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                            :class="{'cursor-not-allowed opacity-25': month == 11 }"
                            :disabled="month == 11 ? true : false"
                            x-on:click="month++; getNoOfDays()">
                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-left b-icon bi"><g transform="translate(0 -0.5)"><g transform="translate(8 8) scale(-1 1) translate(-8 -8)"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>									  
                        </button>
                        <button
                            type="button"
                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
                            x-on:click="year++; getNoOfDays()">
                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="chevron double left" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-chevron-double-left b-icon bi"><g transform="translate(0 -0.5)"><g transform="translate(8 8) scale(-1 1) translate(-8 -8)"><path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path><path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path></g></g></svg>								  
                        </button>
                    </div>
                    
                    <div class="border border-gray-500 p-2 rounded">
                        <div class="flex justify-center mb-1">
                            <div>
                                <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3 -mx-1">
                            <template x-for="(day, index) in DAYS" :key="index">	
                                <div style="width: 14.26%" class="px-1">
                                    <div
                                        x-text="day" 
                                        class="text-gray-800 font-medium text-center text-xs"></div>
                                </div>
                            </template>
                        </div>
                        <div class="flex flex-wrap -mx-1">
                            <template x-for="blankday in blankdays">
                                <div 
                                    style="width: 14.28%"
                                    class="text-center border p-1 border-transparent text-sm"	
                                ></div>
                            </template>	
                            <template x-for="(date, dateIndex) in no_of_days" :key="'no_of_days_' + dateIndex">	
                                <div style="width: 14.28%" class="px-1 mb-1">
                                    <div
                                        x-on:click="getDateValue(date, $dispatch); updateValueEndDispatchEvent($dispatch)"
                                        x-text="date"
                                        class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                        :class="{
                                            'font-bold': true,
                                            'bg-blue-500 text-white': dateIsSelected(date), 
                                            'text-blue-500': isToday(date) == true, 
                                            'text-gray-700 hover:bg-blue-200': isToday(date) == false && !dateIsSelected(date)
                                        }"	
                                    ></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-2 p-2 w-full border border-gray-500 p-2 rounded">
                        <div class="flex align-center justify-center">
                            <select name="hours" class="bg-transparent text-xl appearance-none outline-none" x-model="timePickerHourValue" x-on:input.stop="updateValueEndDispatchEvent($dispatch)">
                                <template x-for="hour in day_hours" :key="'day_hours_' + hour">
                                    <option x-bind:value="hour" x-text="hour"></option>
                                </template>
                            </select>
                            <span class="text-xl mr-1">:</span>
                            <select name="minutes" class="bg-transparent text-xl appearance-none outline-none mr-4" x-model="timePickerMinuteValue" x-on:input.stop="updateValueEndDispatchEvent($dispatch)">
                                <template x-for="minutes in select_minutes">
                                    <option x-bind:value="minutes" x-text="minutes"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="flex mt-2">
                        <button class="bg-gray-500 w-full rounded p-1 text-white mr-3" x-on:click="showDatepicker = false">
                            Cancelar
                        </button>
                        <button class="bg-green-500 w-full rounded p-1 text-white" x-on:click="updateValueEndDispatchEvent($dispatch); showDatepicker = false">
                            Salvar
                        </button>
                    </div> --}}
                </div>

        </div>	 
    </div>
    @include('form-fields.livewire-fields.error-help')
</div>

@push('scripts')
    <script>
        const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const DAYS = [ 'dom.', 'seg.', 'ter.', 'qua.', 'qui.', 'sex.', 'sáb' ];
        const SELECT_MINUTES_OFFSET = 5;
        function app(args) {
            return {
                value: args.value || null,
                get valueString() {
                    return formatDate(new Date(this.value), 'dd/MM/yyyy HH:mm:ss')
                },

                showDatepicker: false,

                datepickerValue: '',
                timePickerHourValue: '10',
                timePickerMinuteValue: '00',

                select_minutes_offset: SELECT_MINUTES_OFFSET,
                select_minutes: Array.from({ length: Math.trunc(60/SELECT_MINUTES_OFFSET) }).map((minute, index) => ('0' + index * SELECT_MINUTES_OFFSET).slice(-2)),
                day_hours: Array.from({ length: 24 }).map((time, index) => ('0' + index).slice(-2)),
                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                initDate() {
                    let selectedDate = this.value ? new Date(this.value) : new Date()
                    if(this.value) {
                        this.timePickerHourValue = ('0' + selectedDate.getHours()).slice(-2)
                        this.timePickerMinuteValue = ('0' + selectedDate.getMinutes()).slice(-2)
                    }

                    this.getNoOfDays()

                    this.month = selectedDate.getMonth();
                    this.year = selectedDate.getFullYear();

                    selectedDate.setMonth(selectedDate.getMonth() - 1)

                    this.datepickerValue = formatDate(selectedDate, 'yyyy-MM-dd');
                },
                
                goToday() {
                    let today = new Date()
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.getNoOfDays();
                },

                dateIsSelected(day) {
                    return new Date(this.value).toDateString() === new Date(this.year, this.month, day).toDateString() ? true : false;
                },
                
                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);

                    return today.toDateString() === d.toDateString() ? true : false;
                },

                changeDateTime() {
                    this.value = formatDate(
                        new Date(...this.datepickerValue.split('-'), this.timePickerHourValue, this.timePickerMinuteValue), 
                        'yyyy-MM-dd HH:mm:ss'
                    )
                },

                getDateValue(day, $dispatch) {
                    this.datepickerValue = formatDate(new Date(this.year, this.month - 1, day), 'yyyy-MM-dd')
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // find where to start calendar day of week
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for ( var i=1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for ( var i=1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                },

                updateValueEndDispatchEvent($dispatch) {
                    this.$nextTick(() => {
                        this.changeDateTime()
                        $dispatch('date-changed', this.value)
                    })
                },

                dispatchInputEvent($el) {
                    $el.value = this.value
                    $el.dispatchEvent(new Event('input', {
                        'bubbles': true,
                        'cancelable': true              
                    }))
                },
            }
        }
    </script>
@endpush