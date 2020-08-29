window.alpineMultiSelectField = (args) => {
    return {
        fieldModelKey: args.fieldModelKey,
        fieldKey: args.fieldKey,
        options: args.options || {},
        get filtredOptions() {
            const values =  Object.entries(this.options).filter(([value, label]) => {
                return value.toLowerCase().includes(this.search.toLowerCase()) || label.toLowerCase().includes(this.search.toLowerCase())
            })
            return values.reduce((acc, [value, label]) => (acc[label] = value, acc), {})
        },
        search: '',
        open: false,
        busy: false,
        realtimeSearchEnabled: args.realtimeSearchEnabled || false,
        selectedValues: args.selectedValues || {},
        topPositionOptions: 0,
        setPositionOptions() {
            this.topPositionOptions = this.$refs.containerInput.offsetHeight + 5
        },
        toggle($dispatch, key, value) {
            if(this.selectedValues.hasOwnProperty(key)) {
                delete this.selectedValues[key]
            } else {
                this.selectedValues[key] = value
            }

            this.$nextTick(() => this.setPositionOptions())

            this.livewireCtx.set(this.fieldModelKey, Object.values(this.selectedValues))
        },
        setLivewireCtx(livewireCtx) {
            this.livewireCtx = livewireCtx
        },
        searchOptions() {
            if(this.realtimeSearchEnabled) {
                this.busy = true
                this.options = Object.assign({})

                this.livewireCtx.call('multiSelectSearch', this.fieldKey, this.search)
                return;    
            }
        },
        onMount() {
            this.setPositionOptions()
            
            window.livewire.on('multiselect-options-changed.' + this.fieldKey, options => {
                this.busy = false
                this.options = options
            })

            this.$watch('search', value => {
                console.log('search ==>', value);
                this.searchOptions()
            })

            this.searchOptions()
        }
    }
}